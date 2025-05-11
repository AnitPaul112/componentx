<?php

namespace App\Http\Controllers;

use App\Models\LendableComponent;
use App\Models\LendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LendingController extends Controller
{
    public function index()
    {
        $components = LendableComponent::where('is_available', true)
            ->with('owner')
            ->latest()
            ->paginate(12);

        return view('lending.index', compact('components'));
    }

    public function create()
    {
        return view('lending.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deposit_amount' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('lendable-components', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        $validated['user_id'] = Auth::id();

        LendableComponent::create($validated);

        return redirect()->route('lending.index')
            ->with('success', 'Component added successfully for lending.');
    }

    public function show(LendableComponent $component)
    {
        $component->load('owner');
        return view('lending.show', compact('component'));
    }

    public function request(LendableComponent $component)
    {
        if ($component->user_id === Auth::id()) {
            return back()->with('error', 'You cannot request to borrow your own component.');
        }

        if (!$component->is_available) {
            return back()->with('error', 'This component is not available for lending.');
        }

        return view('lending.request', compact('component'));
    }

    public function storeRequest(Request $request, LendableComponent $component)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string',
        ]);

        $validated['lendable_component_id'] = $component->id;
        $validated['borrower_id'] = Auth::id();
        $validated['lender_id'] = $component->user_id;

        LendingRequest::create($validated);

        return redirect()->route('lending.index')
            ->with('success', 'Lending request submitted successfully.');
    }

    public function myComponents()
    {
        $components = LendableComponent::where('user_id', Auth::id())
            ->withCount('lendingRequests')
            ->latest()
            ->paginate(10);

        return view('lending.my-components', compact('components'));
    }

    public function myRequests()
    {
        $borrowedRequests = LendingRequest::where('borrower_id', Auth::id())
            ->with(['component', 'lender'])
            ->latest()
            ->paginate(10);

        $lentRequests = LendingRequest::where('lender_id', Auth::id())
            ->with(['component', 'borrower'])
            ->latest()
            ->paginate(10);

        return view('lending.my-requests', compact('borrowedRequests', 'lentRequests'));
    }

    public function updateRequestStatus(LendingRequest $request, $status)
    {
        if ($request->lender_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if (!in_array($status, ['approved', 'rejected', 'completed', 'cancelled'])) {
            return back()->with('error', 'Invalid status.');
        }

        $request->update(['status' => $status]);

        if ($status === 'approved') {
            $request->component->update(['is_available' => false]);
        } elseif ($status === 'completed' || $status === 'cancelled') {
            $request->component->update(['is_available' => true]);
        }

        return back()->with('success', 'Request status updated successfully.');
    }
} 
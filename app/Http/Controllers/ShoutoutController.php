<?php

namespace App\Http\Controllers;

use App\Models\Shoutout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShoutoutController extends Controller
{
    public function index()
    {
        // Fetch all shoutouts from the database
        $shoutouts = Shoutout::latest()->get()->reverse();
       
        return view('shoutout.index', compact('shoutouts'));
    }

    public function store(Request $request)
    {
        // Validate the shoutout
        $request->validate([
            'message' => 'required',
        ]);
    
        // Store the shoutout in the database
        Shoutout::create([
            'username' => Auth::user()->name,
            'message' => $request->message,
        ]);
    
        // Fetch the updated shoutouts and render the updated HTML
        $shoutouts = Shoutout::latest()->get();
         // Redirect to the shout.index route
    return redirect()->route('shoutout.index')->with('successMessage', 'Your shoutout has been posted!');
}
};


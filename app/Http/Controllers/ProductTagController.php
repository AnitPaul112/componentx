<?php

namespace App\Http\Controllers;

use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductTagController extends Controller
{
    public function index()
    {
        $tags = ProductTag::withCount('products')->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_tags',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        ProductTag::create($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    public function edit(ProductTag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, ProductTag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_tags,name,' . $tag->id,
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $tag->update($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    public function destroy(ProductTag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully.');
    }
} 
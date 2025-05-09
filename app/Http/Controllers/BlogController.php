<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all()->reverse();
        return view('blog', compact('blogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'username' => 'required|max:255',
            'blog_text' => 'required',
        ]);

        Blog::create($request->all());

        return redirect()->back()->with('success', 'Blog created successfully!');
    }
    public function showBlogs()
    {
        $blogs = Blog::all(); // Or any other logic to retrieve blogs
        return view('viewblogs', compact('blogs'));
    }
}

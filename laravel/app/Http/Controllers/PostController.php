<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    // Display the post form and table
    public function index()
    {
        Log::info('Displaying post form.');
        return view('post');
    }

    // Handle the form submission
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
        ]);

        Log::info('Post submitted', [
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('post.form')->with('status', 'Post submitted!');
    }
}

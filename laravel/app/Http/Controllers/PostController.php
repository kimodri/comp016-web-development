<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    // Display the post form and table
    public function index()
    {
        Log::info('Displaying post form.');

        $posts = DB::table('post')
            ->leftJoin('statuses', 'post.status', 'statuses.id')  // LEFT JOIN statuses ON status_id
            ->select('post.*', 'statuses.display_name as status_name', 'statuses.name as sname')   // SELECT post.*, statuses.display_name AS status_name
            ->get();
        $statuses = DB::table('statuses')->get();  // SELECT * FROM statuses
        // return $posts;
        return view('post', compact('posts', 'statuses'));
    }

    // Handle the form submission
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            // 'description' => ['required'],
        ]);

        Log::info('Post submitted', [
            'title' => $request->title,
            'description' => $request->description,
        ]);

        DB::table('post')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => 1,
            'created_at' => now(),  // date today
            'status' => $request->status
        ]);

        return redirect()->route('post.form');
        // return redirect()->route('post.form')->with('status', 'Post submitted!');
    }


    public function showUpdate($id)
    {

        $statuses = DB::table('statuses')->get();
        $post = DB::table('post')->find($id);

        return view('post-update', compact('statuses', 'post'));
    }

    public function updateSubmit(Request $request, $id)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'status' => ['required']
        ]);
        
        DB::table('post')
            ->where('id', $id)  
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'updated_at' => now()
            ]);

        return redirect()->route('post.form');

    }
}

// Querybuilder
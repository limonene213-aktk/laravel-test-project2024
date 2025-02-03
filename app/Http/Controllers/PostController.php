<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function create() {
        return view('post.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|max:30',
            'body' =>  'required|max:400',
        ]);

        $post = Post::create($validated);
        return back();
    }
}

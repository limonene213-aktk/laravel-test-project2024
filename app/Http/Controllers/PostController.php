<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        //Eloquent ORMで全てのpostsテーブルデータを取得
        //$posts=Post::all();

        //ログインユーザーしか投稿を見られないようにする
        $posts = Post::where('user_id', auth()->id())->get();
        return view('post.index', compact('posts'));
    }
    public function create() {
        return view('post.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|max:30',
            'body' =>  'required|max:400',
        ]);

        $validated['user_id']=auth()->id();

        $post = Post::create($validated);
        return back();
    }
}

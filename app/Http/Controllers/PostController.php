<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('pages.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $recentPosts = Post::where('id', '!=', $post->id)->latest()->take(5)->get();
        return view('pages.posts.show', compact('post', 'recentPosts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $posts = Post::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->paginate(10);

        return view('pages.posts.search', compact('posts'));
    }
}

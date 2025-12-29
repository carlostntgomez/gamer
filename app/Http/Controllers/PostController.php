<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(9);
        $recentPosts = Post::latest()->take(5)->get();
        $allTags = Tag::all();
        return view('pages.posts.index', compact('posts', 'recentPosts', 'allTags'));
    }

    public function show(Post $post)
    {
        $recentPosts = Post::where('id', '!=', $post->id)->latest()->take(5)->get();
        $allTags = Tag::all();
        $previousPost = Post::where('published_at', '<', $post->published_at)->orderBy('published_at', 'desc')->first();
        $nextPost = Post::where('published_at', '>', $post->published_at)->orderBy('published_at', 'asc')->first();

        return view('pages.posts.show', compact('post', 'recentPosts', 'allTags', 'previousPost', 'nextPost'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $postsQuery = Post::query();

        if ($query) {
            $postsQuery->where(function($builder) use ($query) {
                $builder->where('title', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
            });
        } else {
            $postsQuery->whereRaw('0 = 1');
        }

        $posts = $postsQuery->latest()->paginate(9);

        return view('pages.posts.search', compact('posts', 'query'));
    }
}

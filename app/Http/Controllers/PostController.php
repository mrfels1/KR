<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CreatePost', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Post::create([
            'title' => $request->input('title'),
            'text' => $request->input('text'),
            'user_id' => $request->user()->id
        ]);
        return redirect()->route('main');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $post = Post::find($request->id)->toArray();
        $post['authorName'] = User::find($post['user_id'])->name;
        $post['url'] = env('APP_URL') . '/post/' . $post['id'];
        $post['authorID'] = env('APP_URL') . '/user/' .$post['user_id'];
        
        return Inertia::render('ViewPost', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'post' => $post,
            'comments' => Post::find($request->id)->comments->sortBy('created_at')->map(function ($comment) {
                return [
                    'text' => $comment->text,
                    'authorName' => User::find($comment->user_id)->name,
                    'created_at' => $comment->created_at,
                    'authorID' => env('APP_URL') . '/user/' .$comment->user_id,
                ];
            })->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}

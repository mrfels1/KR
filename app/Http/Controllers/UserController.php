<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    public function mypage(Request $request){
        return Inertia::render("Profile", [ 
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'user' => $request->user(),
            'posts' => Post::where('user_id', $request->user()->id)
                          ->orderByDesc('created_at')
                          ->get()
                          ->map(function ($post) {
                return [
                    'title' => $post->title,
                    'text' => $post->text,
                    'authorName' => User::find($post->user_id)->name,
                    'url' => env('APP_URL') . '/post/' . $post->id,
                    'authorID' => env('APP_URL') . '/user/' .$post->user_id,
                ];
            })->toArray(),
        ]);
    }
    
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
        return Inertia::render("Profile", [ 
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'user' => User::find($request->id),
            'posts' => Post::where('user_id', $request->id)
                          ->orderByDesc('created_at')
                          ->get()
                          ->map(function ($post) {
                return [
                    'title' => $post->title,
                    'text' => $post->text,
                    'authorName' => User::find($post->user_id)->name,
                    'url' => env('APP_URL') . '/post/' . $post->id,
                    'authorID' => env('APP_URL') . '/user/' .$post->user_id,
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

<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    $posts = Post::orderByDesc('created_at')->get()->map(function ($post) {
        return [
            'title' => $post->title,
            'text' => $post->text,
            'authorName' => User::find($post->user_id)->name,
            'url' => env('APP_URL') . '/post/' . $post->id,
            'authorID' => env('APP_URL') . '/user/' .$post->user_id,
        ];
    })->toArray();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'posts' => $posts,
    ]);
})->name('main');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/create-post', [PostController::class,'create'])->name('create-post');
    Route::post('/create-post', [PostController::class,'store'])->name('create-post');

    Route::get('/user', [UserController::class, 'mypage'])->name('mypage');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('page');

    Route::get('/post/{id}', [PostController::class, 'show'])->name('view-post');

    Route::post('/create-comment', [CommentController::class, 'store'])->name('create-comment');
});




require __DIR__.'/auth.php';

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
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $posts = Post::orderByDesc('created_at')->get()->map(function ($post) use ($request) {
        if ($request->user()) {
            $isLiked = $post->isLikedByUser($request->user()->id);
            $isDisliked = $post->isDislikedByUser($request->user()->id);
        } else {
            $isLiked = null;
            $isDisliked = null;
        }
        return [
            'title' => $post->title,
            'text' => $post->text,
            'authorName' => User::find($post->user_id)->name,
            'url' => env('APP_URL') . '/post/' . $post->id,
            'authorID' => env('APP_URL') . '/user/' . $post->user_id,
            'likesCount' => $post->likescount(),
            'dislikesCount' => $post->dislikescount(),
            'isLiked' => $isLiked,
            'isDisliked' => $isDisliked,
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


    Route::get('/create-post', [PostController::class, 'create'])->name('create-post');
    Route::post('/create-post', [PostController::class, 'store'])->name('create-post');

    Route::get('/user', [UserController::class, 'mypage'])->name('mypage');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('page');
    Route::get('/users', [UserController::class, 'index'])->name('search-users');
    Route::get('/post/{id}', [PostController::class, 'show'])->name('view-post');

    Route::post('/create-comment', [CommentController::class, 'store'])->name('create-comment');

    Route::post('/like/{postid}', [LikeController::class, 'like'])->name('like');
    Route::post('/dislike/{postid}', [LikeController::class, 'dislike'])->name('dislike');
    Route::post('/remove-like/{postid}', [LikeController::class, 'removeLike'])->name('remove-like');



    Route::post('/subscribe/{userid}', [SubscribeController::class, 'subscribe'])->name('subscribe');
    Route::post('/unsubscribe/{userid}', [SubscribeController::class, 'unsubscribe'])->name('unsubscribe');

    Route::get('/sub_posts', [UserController::class, 'sub_posts'])->name('sub_posts');
});




require __DIR__ . '/auth.php';

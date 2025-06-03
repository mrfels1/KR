<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user",
     *     summary="Show the user's profile page",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function mypage(Request $request)
    {
        return Inertia::render("Profile", [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'user' => User::find($request->user()->id),
            'is_subscribed' => null,
            'posts' => Post::where('user_id', $request->user()->id)
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($post) {
                    return [
                        'title' => $post->title,
                        'text' => $post->text,
                        'authorName' => User::find($post->user_id)->name,
                        'url' => env('APP_URL') . '/post/' . $post->id,
                        'authorID' => env('APP_URL') . '/user/' . $post->user_id,
                        'likesCount' => $post->likescount(),
                        'dislikesCount' => $post->dislikescount(),
                        'isLiked' => $post->isLikedByUser(auth()->user()->id),
                        'isDisliked' => $post->isDislikedByUser(auth()->user()->id),
                    ];
                })->toArray(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render("UsersList", [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'users' => User::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'url' => env('APP_URL') . '/user/' . $user->id,
                    'postsCount' => $user->posts()->count(),
                ];
            })->toArray()
        ]);
    }



    /**
     * @OA\Get(
     *     path="/user/create",
     *     summary="Show the form for creating a new resource.",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function create()
    {
        return Inertia::render('CreatePost', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/user",
     *     summary="Store a newly created resource in storage.",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", example="Some title"),
     *             @OA\Property(property="text", type="string", example="Some text")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation"
     *     )
     * )
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
     * @OA\Get(
     *     path="/user/{id}",
     *     summary="Display the specified user.",
     *     tags={"User"},
     *     @OA\Parameter(
     *         description="id of the user",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example=1,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(
     *                 property="posts",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Post")
     *             )
     *         )
     *     )
     * )
     */
    public function show(Request $request)
    {
        return Inertia::render("Profile", [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'user' => User::find($request->id),
            'is_subscribed' => auth()->user() ? auth()->user()->isSubscribedTo($request->id) : false,
            'posts' => Post::where('user_id', $request->id)
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($post) {
                    return [
                        'title' => $post->title,
                        'text' => $post->text,
                        'authorName' => User::find($post->user_id)->name,
                        'url' => env('APP_URL') . '/post/' . $post->id,
                        'authorID' => env('APP_URL') . '/user/' . $post->user_id,
                        'likesCount' => $post->likescount(),
                        'dislikesCount' => $post->dislikescount(),
                        'isLiked' => $post->isLikedByUser(auth()->user()->id),
                        'isDisliked' => $post->isDislikedByUser(auth()->user()->id),
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

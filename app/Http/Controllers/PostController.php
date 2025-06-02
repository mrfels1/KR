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
     * @OA\Info(
     *     title="Forum API",
     *     version="1.0.0",
     *     description="API for the forum application"
     * )
     */


    public function index()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/posts/create",
     *     summary="Show the form for creating a new resource.",
     *     tags={"Post"},
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
     *     path="/posts",
     *     summary="Store a newly created resource in storage.",
     *     tags={"Post"},
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
     *     path="/posts/{id}",
     *     summary="Display the specified resource.",
     *     tags={"Post"},
     *     @OA\Parameter(
     *         description="id of the post",
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
     *             @OA\Property(property="post", ref="#/components/schemas/Post"),
     *             @OA\Property(
     *                 property="comments",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Comment")
     *             )
     *         )
     *     )
     * )
     */
    public function show(Request $request)
    {
        $post = Post::find($request->id)->toArray();
        $post['authorName'] = User::find($post['user_id'])->name;
        $post['url'] = env('APP_URL') . '/post/' . $post['id'];
        $post['authorID'] = env('APP_URL') . '/user/' . $post['user_id'];

        return Inertia::render('ViewPost', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'post' => $post,
            'comments' => Post::find($request->id)->comments->sortBy('created_at')->map(function ($comment) {
                return [
                    'text' => $comment->text,
                    'authorName' => User::find($comment->user_id)->name,
                    'created_at' => $comment->created_at,
                    'authorID' => env('APP_URL') . '/user/' . $comment->user_id,
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

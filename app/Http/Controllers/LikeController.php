<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, $postid)
    {
        $like = Like::where('user_id', $request->user()->id)->where('post_id', $postid)->first();

        if ($like) {
            $like->is_liked = true;
            $like->save();
        } else {
            Like::create([
                'user_id' => $request->user()->id,
                'post_id' => $postid,
                'is_liked' => true,
            ]);
        }
    }

    public function dislike(Request $request, $postid)
    {
        $like = Like::where('user_id', $request->user()->id)->where('post_id', $postid)->first();

        if ($like) {
            $like->is_liked = false;
            $like->save();
        } else {
            Like::create([
                'user_id' => $request->user()->id,
                'post_id' => $postid,
                'is_liked' => false,
            ]);
        }
    }

    public function removeLike(Request $request, $postid)
    {
        Like::where('user_id', $request->user()->id)->where('post_id', $postid)->delete();
    }
}

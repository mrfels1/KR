<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Post model",
 *     description="Post model",
 *     @OA\Xml(
 *         name="Post"
 *     ),
 *     @OA\Property(
 *         property="id",
 *         description="The ID of the post",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         description="The ID of the user who created the post",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="text",
 *         description="The text of the post",
 *         type="string",
 *         example="Some text"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         description="The title of the post",
 *         type="string",
 *         example="Some title"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         description="The date and time the post was created",
 *         type="string",
 *         format="date-time",
 *         example="2022-01-01 12:00:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         description="The date and time the post was updated",
 *         type="string",
 *         format="date-time",
 *         example="2022-01-01 12:00:00"
 *     )
 * )
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'title',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likescount()
    {
        return $this->likes()->where('is_liked', true)->count();
    }

    public function dislikescount()
    {
        return $this->likes()->where('is_liked', false)->count();
    }
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->where('is_liked', true)->exists();
    }
    public function isDislikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->where('is_liked', false)->exists();
    }
}

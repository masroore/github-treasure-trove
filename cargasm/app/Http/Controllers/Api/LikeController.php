<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LikeRequest;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    public function like(LikeRequest $request)
    {
        /** @var User $user */
        if ($request->type === 'post') {
            $user = auth()->user();
        }
        $checkLike = $request->type === 'post' ? $user->checkLikePost($request->id) : $user->checkLikeComment($request->id);
        $entityType = $request->type === 'post' ? 'App\Models\Post' : 'App\Models\Comment';

        if ($checkLike) {
            $user->likes()->where([
                'entity_type' => $entityType,
                'entity_id' => $request->id,
            ])->delete();
            $likeCount = Like::where('entity_type', $entityType)->where('entity_id', $request->id)->count();

            return response()->json(['message' => trans('system.like.delete'), 'count' => $likeCount], Response::HTTP_OK);
        }

        $user->likes()->create([
            'entity_type' => $entityType,
            'entity_id' => $request->id,
        ]);
        $likeCount = Like::where('entity_type', $entityType)->where('entity_id', $request->id)->count();

        return response()->json(['message' => trans('system.like.save'), 'count' => $likeCount], Response::HTTP_OK);
    }
}

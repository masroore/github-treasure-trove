<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\StoreRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class CommentService
{
    /**
     * @var
     */
    protected $userRepository;

    protected $storeRepository;

    protected $commentRepository;

    protected $productRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        StoreRepositoryInterface $storeRepository,
        CommentRepositoryInterface $commentRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->userRepository = $userRepository;
        $this->storeRepository = $storeRepository;
        $this->commentRepository = $commentRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Get all Categories of a user.
     */
    public function store(Request $request)
    {
        try {
            $request['user_id'] = ((1 == $request->is_anonymous) ? Auth::id() : null);
            // validate request
            $validator = Validator::make($request->input(), [
                'rating' => 'required',
            ]);
            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            $comment = $this->commentRepository->create(
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $comment;
    }

    public function showProducts($id)
    {
        try {
            $comments = $this->productRepository->findByColumn([
                'id' => $id,
            ], ['*'], ['defaultProductAttributes',
                'variations.productAttributes',
                'variations.product', 'comments', ]);
            $comments['stats'] = averageRating($id, 'App\Models\Products');
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $comments;
    }

    public function showStores($id)
    {
        try {
            $comments = $this->storeRepository->findByColumn([
                'id' => $id,
            ], ['*'], ['comments']);
            $comments['stats'] = averageRating($id, 'App\Models\Store');
//             dd($data);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $comments;
    }

    public function destroy($id)
    {
        try {
            $comment = $this->commentRepository->deleteByColumn(
                ['id' => $id,
                    'user_id' => Auth::id(), ]
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $comment;
    }

    public function update(Request $request, $id)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'rating' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            $comment = $this->commentRepository->updateByColumn(
                ['id' => $id, 'user_id' => Auth::id()],
                ['rating' => $request->rating, 'body' => $request->body]
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $comment;
    }

    public function like(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'comment_id' => 'required',
            ]);
            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $like = Comment::where('id', $request->id)->increment('likes', 1);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $like;
    }
}

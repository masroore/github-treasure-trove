<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Repositories\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * @var Comment
     */
    protected $model;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }
}

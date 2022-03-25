<?php

namespace App\Repositories\Eloquent;

use App\Models\CardSession;
use App\Repositories\CardSessionRepositoryInterface;

class CardSessionRepository extends BaseRepository implements CardSessionRepositoryInterface
{
    /**
     * @var CardSession
     */
    protected $model;

    public function __construct(CardSession $model)
    {
        $this->model = $model;
    }
}

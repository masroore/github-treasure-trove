<?php

namespace App\Events\Category;

use App\Category;
use App\Team;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $categoryData;

    public $team;

    public function __construct($category, Team $team)
    {
        $this->categoryData = $category->toArray();
        $this->team = $team;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|\Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('team.' . $this->team->id);
    }

    public function broadcastWhen()
    {
        return $this->categoryData['type'] == Category::TYPE_PUBLIC;
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->categoryData['id'],
        ];
    }
}

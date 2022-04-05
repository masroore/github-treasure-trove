<?php

namespace App\Events;

use App\Models\Student;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewSubmission
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $submission;

    public $task;

    public $studentName;

    /**
     * Create a new event instance.
     */
    public function __construct(Student $student, $task_id)
    {
        $this->studentName = $student->user->name;
        $this->task = $student->tasks()->where('task_id', $task_id)->first();
        $this->submission = $this->task->pivot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|\Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

<?php

namespace App\Notifications\Task\Email;

use App\Repositories\TaskRepository;
use App\Task;
use App\Team;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Subscribed extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $task;

    public $team;

    public $user;

    private $taskRepository;

    public function __construct(Task $task, Team $team, User $user)
    {
        $this->task = $task;
        $this->team = $team;
        $this->user = $user;
        $this->taskRepository = new TaskRepository();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->task = $this->taskRepository->loadMailInfo($this->task, $this->team, $notifiable);
        $username = $this->team->users->find($this->user->id)->pivot->username;

        return (new MailMessage())
            ->from(config('mail.from.address'), config('app.name') . ': ' . $this->team->name)
            ->subject($username . ' mentioned you in ' . $this->task->name)
            ->markdown('mail.task.email.subscribed', ['task' => $this->task, 'username' => $username]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}

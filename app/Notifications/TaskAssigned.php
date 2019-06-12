<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\TaskAssigned as Mailable;
use App\Task;

class TaskAssigned extends Notification
{
    use Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new Mailable($this->task))
            ->subject('NUEVA TAREA')
            ->to($this->task->user->email);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

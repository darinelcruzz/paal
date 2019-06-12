<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Task;

class TaskAssigned extends Mailable
{
    use Queueable, SerializesModels;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    function build()
    {
        return $this->markdown('mail.task.assigned', ['task' => $this->task]);
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Notification;

class TaskNotAccepted extends Notification
{
    use Queueable;

    public function __construct($reasons)
    {
        $this->reasons = $reasons;
    }

    public function via($task)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($task)
    {
        $url = env('APP_URL') . '/coffee/tareas';

        $message = "{$task->user->name} la tarea que completaste no fue aceptada por *{$task->tasker->name}* por las siguientes razones:\n {$this->reasons}";

        return TelegramMessage::create()
            ->to($task->user->telegram_user_id)
            ->content($message)
            ->button('Ver detalles', $url);
    }
}
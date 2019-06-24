<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Notification;

class TaskMarkedAsFinished extends Notification
{
    use Queueable;

    public function via($task)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($task)
    {
        $url = env('APP_URL') . '/coffee/tareas';

        $message = "{$task->tasker->name} la tarea que asignaste a *{$task->user->name}* se marcó como TERMINADA.\nRevisala para aceptar.";

        return TelegramMessage::create()
            ->to($task->tasker->telegram_user_id)
            ->content($message)
            ->button('Ver detalles', $url);
    }
}
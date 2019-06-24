<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Notification;

class TaskCreatedAndAssigned extends Notification
{
    use Queueable;

    public function via($task)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($task)
    {
        $url = env('APP_URL') . '/coffee/tareas';

        $message = "Hola, {$task->user->name} se te ha asignado la siguiente tarea:\n *{$task->description}* \nPor favor completala antes del\n *" . fdate($task->assigned_at, 'd \d\e F', 'Y-m-d') . "*.";

        return TelegramMessage::create()
            ->to($task->user->telegram_user_id)
            ->content($message)
            ->button('Ver detalles', $url);
    }
}
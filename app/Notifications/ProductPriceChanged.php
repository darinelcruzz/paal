<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Notification;

class ProductPriceChanged extends Notification
{
    use Queueable;

    public function __construct($user, $old_values = null)
    {
        $this->user = $user;
        $this->old_values = $old_values;
    }

    public function via($product)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($product)
    {
        if ($product->wholesale_quantity > 0) {
            $message = "*$this->user* modificó los precios de *$product->description*:\nMENUDEO >> de $" . number_format($this->old_values[0], 2) .
            " a $" . number_format($product->retail_price, 2) . 
            "\nMAYOREO >> de $" . number_format($this->old_values[1], 2) . " a $" . number_format($product->wholesale_price, 2);

        } else {
            $message = "$this->user modificó el precio de *$product->description*:\nDe $" . number_format($this->old_values, 2)
            . " a $" . number_format($product->retail_price, 2);
        }


        return TelegramMessage::create()
            ->to(env('TELEGRAM_BOT_ID'))
            ->content($message);
    }
}

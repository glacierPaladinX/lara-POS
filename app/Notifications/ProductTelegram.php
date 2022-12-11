<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class ProductTelegram extends Notification
{
    use Queueable;

    /**
     * @param mixed $Product
     * @return void
     */
    public function __construct($telegramChannel, $productName, $productPrice, $productImage)
    {
        $this->telegramChannel = $telegramChannel;
        $this->productName = $productName;
        $this->productPrice = $productPrice;
        $this->productImage = $productImage;
    }

    /**
     * @param mixed $notifiable
     * @return string[]
     */
    public function via($notifiable)
    {
        return ['telegram'];
    }

    /**
     * @param mixed $notifiable
     * @return \NotificationChannels\Telegram\TelegramMessage
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($this->telegramChannel)
            ->content("Check out our new product: $this->productName for $$this->productPrice")
            ->file("/$this->productImage", 'photo');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'product_name'  => $this->productName,
            'product_price' => $this->productPrice,
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRestaurantSignup extends BaseNotification
{

    public $restaurant;

    /**
     * Create a new notification instance.
     */
    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $build = parent::build($notifiable);
        $siteName = global_setting()->name;
        return $build
            ->subject('New Restaurant Signup on '.$siteName.'! 🎉')
            ->greeting(__('app.hello') .' '. $notifiable->name . ',')
            ->line('We\'re excited to inform you that a new restaurant has just signed up for '.$siteName.'! 🎉')
            ->line('Restaurant Name: ' . $this->restaurant->name);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

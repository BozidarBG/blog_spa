<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $url;


    public function __construct($url)
    {
        $this->url=$url;
        info($this->url);
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have forgotten your password?')
            ->action('Click to reset',$this->url)
            //->line("or paste into browser following link: $this->url")
            ->line('If it was not you who demanded this, please, let us know.')
            ->line('Thank you, ');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

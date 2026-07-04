<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;

class LoginNeedsVerification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [TwilioChannel::class];
    }


    public function toTwilio(object $notifiable): \NotificationChannels\Twilio\TwilioSmsMessage
    {
        $OTP = rand(100000, 999999); // Generate a random 6-digit OTP
        $notifiable->update([
            'login_code' => $OTP,
        ]);
        return (new \NotificationChannels\Twilio\TwilioSmsMessage())
                    ->content("Your OTP is: {$OTP}, please do not share it with anyone. It will expire in 5 minutes.");
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

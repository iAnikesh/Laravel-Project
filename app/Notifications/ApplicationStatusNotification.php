<?php

namespace App\Notifications;

use App\Models\HousingApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public HousingApplication $application,
        public string $message,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Housing application update — '.$this->application->application_number)
            ->line($this->message)
            ->action('View application', route('applications.show', $this->application));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'application_number' => $this->application->application_number,
            'status' => $this->application->status->value,
            'message' => $this->message,
        ];
    }
}

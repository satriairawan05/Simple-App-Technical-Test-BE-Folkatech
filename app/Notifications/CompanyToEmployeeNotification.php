<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyToEmployeeNotification extends Notification
{
    use Queueable;

    private $company;
    private $employee;
    private $employeeName;

    /**
     * Create a new notification instance.
     */
    public function __construct($company, $employee, $employeeName)
    {
        $this->company = $company;
        $this->employee = $employee;
        $this->employeeName = $employeeName;
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
        return (new MailMessage)
                    ->from($this->company)
                    ->line('Welcome to our Application!')
                    ->greeting('Hello '. $this->employeeName . ' Selamat Datang!')
                    ->action('Notification Action', route('employee.index'))
                    ->line('Thank you for using our application!');
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

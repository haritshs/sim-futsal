<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Admin;
use App\Jabatan;

class BookSuccess extends Notification
{
    use Queueable;
    protected $jabatan;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($jabatan)
    {
        $this->jabatan=$jabatan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'jabatan' => $this->jabatan,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'jabatan' => $this->jabatan,
        ];
    }
}

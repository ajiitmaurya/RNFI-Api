<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCreatedNotification extends Notification
{
   use Queueable;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // store in DB + broadcast realtime
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->task->title,
            'description' => $this->task->description,
            'status' => $this->task->status,
        ];
    }
}

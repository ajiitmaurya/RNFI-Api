<?php
namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCreated implements ShouldBroadcast
{
     use Dispatchable, InteractsWithSockets, SerializesModels, Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    // Broadcasting channel (per user)
    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->task->user_id);
    }

    // Custom event name
    public function broadcastAs()
    {
        return 'TaskCreated';
    }

    // Payload
    public function broadcastWith()
    {
        return [
            'id'       => $this->task->id,
            'title'    => $this->task->title,
            'status'   => $this->task->status,
            'user_id'  => $this->task->user_id,
        ];
    }
}

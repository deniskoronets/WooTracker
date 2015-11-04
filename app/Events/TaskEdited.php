<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Task;

class TaskEdited extends Event
{
    use SerializesModels;

    private $task;
    private $oldTask;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $oldTask, Task $task)
    {
    	$this->oldTask = (object)$oldTask;
        $this->task = $task;
    }

    public function getOldTask()
    {
    	return $this->oldTask;
    }

    public function getTask()
    {
    	return $this->task;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}

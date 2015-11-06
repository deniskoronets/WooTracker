<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\TaskComment;

class TaskCommentEvent extends Event
{
    use SerializesModels;

    const EVENT_CREATED = 'created';
    const EVENT_DELETED = 'deleted';
    const EVENT_EDITED = 'edited';

    private $eventType;
    private $taskComment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($eventType, TaskComment $taskComment)
    {
        $this->eventType = $eventType;
        $this->taskComment = $taskComment;
    }

    public function getEventType()
    {
    	return $this->eventType;
    }

    public function getTaskComment()
    {
    	return $this->taskComment;
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

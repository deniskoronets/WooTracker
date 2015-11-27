<?php

namespace App\Listeners;

use App\Events\TaskCommentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use App\Models\TaskLog;
use Carbon\Carbon;

class TaskCommentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskCommentEvent  $event
     * @return void
     */
    public function handle(TaskCommentEvent $event)
    {
    	$comment = $event->getTaskComment();
    	$originalComment = $comment->getOriginal();

    	switch ($event->getEventType()) {
    		case TaskCommentEvent::EVENT_CREATED:
    			$eventDescription = 'Comment created with text: <b>"' . Str::words(strip_tags($comment->description), 10) . '"</b>';
    		break;

    		case TaskCommentEvent::EVENT_EDITED:
    			$eventDescription = 'Comment edited, text changed from <b>"' . strip_tags($originalComment['description']) . '"</b>' .
    								' to <b>"' . strip_tags($comment->description) . '"</b>';
			break;

			case TaskCommentEvent::EVENT_DELETED:
				$eventDescription = 'Comment deleted with text: <b>"' . Str::words(strip_tags($comment->description), 10) . '"</b>';
			break;

			default:
				$eventDescription = 'Unknown event';
    	}

        TaskLog::create([
        	'task_id' => $comment->task_id,
        	'description' => $eventDescription,
        	'log_date' => Carbon::now(),
    	]);
    }
}

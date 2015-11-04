<?php

namespace App\Listeners;

use App\Events\TaskEdited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\TaskLog;
use Carbon\Carbon;

class TaskLogger
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
     * @param  TaskEdited  $event
     * @return void
     */
    public function handle(TaskEdited $event)
    {
    	$description = [];

    	$oldTask = $event->getOldTask();
    	$task = $event->getTask();

    	if ($oldTask->name != $task->name) {
    		$description[] = 'Task name changed from <b>"' . $oldTask->name . '"</b> to <b>"' . $task->name . '"</b>';
    	}

    	if ($oldTask->description != $task->description) {
    		$description[] = 'Task description changed';
    	}

    	if ($oldTask->assigned_id != $task->assigned_id) {
    		$description[] = 'Task assigned_id changed from <b>"' . $oldTask->assigned_id . '"</b> to <b>"' . $task->assigned_id . '"</b>';
    	}

    	if ($oldTask->status_id != $task->status_id) {
    		$description[] = 'Task status_id changed from <b>"' . $oldTask->status_id . '"</b> to <b>"' . $task->status_id . '"</b>';
    	}

    	if (empty($description)) {
    		return;
    	}

    	$description = implode('<br>', $description);

        TaskLog::create([
        	'task_id' => $event->getTask()->id,
        	'description' => $description,
        	'log_date' => Carbon::now(),
    	]);
    }
}

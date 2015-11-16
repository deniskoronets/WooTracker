<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Status;
use Validator;
use Auth;
use Event;
use App\Events\TaskEdited;
use App\Models\TaskComment;
use App\Events\TaskCommentEvent;
use App\Models\Project;
use App\Models\Label;
use App\Models\TaskLabel;
use DB;

class TaskController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	private function _getValidator(Request $request)
	{
		return Validator::make($request->all(), [
		    'name' => 'required|max:255',
		    'description' => 'required',
		    'assigned_id' => 'required|integer',
		    'status_id' => 'required|integer',
		]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($projectId, Request $request)
    {
    	$project = Project::findOrFail($projectId);

        if ($request->isMethod('post'))
		{
			$validator = $this->_getValidator($request);

			if ($validator->fails()) {
				return redirect('/tasks/create/project-' . $projectId)->withErrors($validator)->withInput();
			}

			DB::transaction(function() use ($request, $projectId) {

				$task = Task::create([
					'owner_id' => Auth::user()->id,
					'project_id' => $projectId,
					'name' => $request->input('name'),
					'description' => $request->input('description'),
					'assigned_id' => $request->input('assigned_id'),
					'status_id' => $request->input('status_id'),
				]);

				foreach ($request->input('label', array()) as $id => $isset) {

					TaskLabel::create([
						'task_id' => $task->id,
						'label_id' => $id,
					]);
				}

			});

			return redirect('/projects/' . $projectId)->with('success', 'Task successfully created');
		}

		return view('task.create', [
			'project' => $project,
			'users' => User::all(),
			'statuses' => Status::all(),
			'labels' => Label::all(),
		]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
    	$task = Task::findOrFail($id);

        return view('task.view', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
    	$task = Task::findOrFail($id);

        if ($request->isMethod('post'))
		{
			$validator = $this->_getValidator($request);

			if ($validator->fails()) {
				return redirect('/tasks/' . $task->id . '/edit')->withErrors($validator)->withInput();
			}

			$oldTask = $task->toArray();

			$task->name = $request->input('name');
			$task->description = $request->input('description');
			$task->assigned_id = $request->input('assigned_id');
			$task->status_id = $request->input('status_id');

			DB::transaction(function() use ($request, $task, $oldTask) {

				$task->save();

				TaskLabel::where('task_id', '=', $task->id)->delete();

				foreach ($request->input('label', array()) as $id => $isset) {

					TaskLabel::create([
						'task_id' => $task->id,
						'label_id' => $id,
					]);
				}

				Event::fire(new TaskEdited($oldTask, $task));
			});

			return redirect('/projects/' . $task->project_id)->with('success', 'Task successfully edited');
		}

		return view('task.edit', [
			'task' => $task,
			'users' => User::all(),
			'statuses' => Status::all(),
			'labels' => Label::all(),
		]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect('/tasks')->with('success', 'Task "' . $task->name . '" successfully deleted');
    }

    public function editComment($id, Request $request)
    {
    	$comment = TaskComment::findOrFail($id);

    	$validator = Validator::make($request->all(), [
    		'task-comment' => 'required',
		]);

		if ($validator->fails()) {
			return [
				'status' => 'error',
				'errors' => $validator->errors()->toArray()
			];
		}

		$comment->description = $request->input('task-comment');
		Event::fire(new TaskCommentEvent(TaskCommentEvent::EVENT_EDITED, $comment));
		$comment->save();

		return [
			'status' => 'ok',
			'errors' => [],
		];
    }

    public function deleteComment($id)
    {
    	$comment = TaskComment::findOrFail($id);
    	Event::fire(new TaskCommentEvent(TaskCommentEvent::EVENT_DELETED, $comment));
		$comment->delete();

		return [
			'status' => 'ok',
			'errors' => [],
		];
    }

    public function addComment($id, Request $request)
    {
    	$task = Task::findOrFail($id);

    	$validator = Validator::make($request->all(), [
		    'task-comment' => 'required',
		]);

		if ($validator->fails()) {
			return redirect('/tasks/' . $task->id)->withErrors($validator)->withInput();
		}

    	$comment = TaskComment::create([
    		'task_id' => $task->id,
    		'owner_id' => Auth::user()->id,
    		'description' => $request->input('task-comment'),
		]);

		Event::fire(new TaskCommentEvent(TaskCommentEvent::EVENT_CREATED, $comment));

    	return redirect('/tasks/' . $task->id)->with('success', 'Comment successfully added');
    }
}

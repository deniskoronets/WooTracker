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
        if ($request->isMethod('post'))
		{
			$validator = $this->_getValidator($request);

			if ($validator->fails()) {
				return redirect('/tasks/create/project-' . $projectId)->withErrors($validator)->withInput();
			}

			Task::create([
				'owner_id' => Auth::user()->id,
				'project_id' => $projectId,
				'name' => $request->input('name'),
				'description' => $request->input('description'),
				'assigned_id' => $request->input('assigned_id'),
				'status_id' => $request->input('status_id'),
			]);

			return redirect('/projects/' . $projectId)->with('success', 'Task successfully created');
		}

		return view('task.create', [
			'users' => User::all(),
			'statuses' => Status::all(),
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

			if ($task->save()) {
				Event::fire(new TaskEdited($oldTask, $task));
			}

			return redirect('/projects/' . $task->project_id)->with('success', 'Task successfully edited');
		}

		return view('task.edit', [
			'task' => $task,
			'users' => User::all(),
			'statuses' => Status::all(),
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
}

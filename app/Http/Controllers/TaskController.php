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

class TaskController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
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
			$validator = Validator::make($request->all(), [
			    'project_id' => 'required|integer',
			    'name' => 'required|max:255',
			    'description' => 'required',
			    'assigned_id' => 'required|integer',
			    'status_id' => 'required|integer',
			]);

			if ($validator->fails()) {
				return redirect('/tasks/create')->withErrors($validator)->withInput();
			}

			Task::create([
				'owner_id' => Auth::user()->id,
				'project_id' => $projectId,
				'name' => $request->input('name'),
				'description' => $request->input('description'),
				'assigned_id' => $request->input('assigned_id'),
				'status_id' => $request->input('status_id'),
			]);

			return redirect('/tasks')->with('success', 'Task successfully created');
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
    public function edit($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

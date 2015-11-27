<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Validator;
use Auth;
use Carbon\Carbon;

class ProjectController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	private function _getValidator(Request $request)
	{
		return Validator::make($request->all(), [
		    'name' => 'required|max:255',
		]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$projects = Project::all();

    	return view('project.index', [
    		'projects' => $projects
    	]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if ($request->isMethod('post'))
		{
			$validator = $this->_getValidator($request);

			if ($validator->fails()) {
				return redirect('/projects/create')->withErrors($validator)->withInput();
			}

			Project::create([
				'owner_id' => Auth::user()->id,
				'name' => $request->input('name'),
				'created_date' => Carbon::now(),
			]);

			return redirect('/projects')->with('success', 'Project successfully created');
		}

		return view('project.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tasks($id)
    {
    	$project = Project::findOrFail($id);

    	$tasks = Task::where('project_id', '=', $id)->get();

        return view('project.tasks', [
        	'tasks' => $tasks,
        	'project' => $project,
    	]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
    	$project = Project::findOrFail($id);

        if ($request->isMethod('post'))
		{
			$validator = $this->_getValidator($request);

			if ($validator->fails()) {
				return redirect('/projects/edit')->withErrors($validator)->withInput();
			}

			$project->name = $request->input('name');
			$project->save();

			return redirect('/projects')->with('success', 'Project successfully edited');
		}

		return view('project.edit', [
			'project' => $project,
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
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect('/projects')->with('success', 'Project "' . $project->name . '" successfully deleted');
    }
}

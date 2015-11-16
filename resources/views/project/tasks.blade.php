@extends('layout')

@section('breadcrumbs')
<li><a href='/projects'>Projects</a></li>
<li>{{ $project->name}}</li>
@stop

@section('content')

	<div class='row'>
		<div class='col-md-6'>
			<h2>Tasks list</h2>
		</div>
		<div class='col-md-6 text-right'>
			<p>
				<a href='/tasks/create/project-{{ $project->id }}' class='btn btn-success' style='margin-top: 13px;'>Create a new task</a>
			</p>
		</div>
	</div>
	<table class='table table-hover table-border'>
		<colgroup>
			<col width='50'>
			<col width='150'>
			<col>
			<col width='200'>
			<col width='150'>
		</colgroup>
		<thead>
			<tr>
				<td>ID</td>
				<td>Owner</td>
				<td>Name</td>
				<td>Assigned</td>
				<td>Status</td>
				<td>Created date</td>
				<td>Actions</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($tasks as $task)
			<tr>
				<td>{{ $task->id }}</td>
				<td><a href='/users/{{ $project->owner->id }}'>{{ $task->owner->name }}</a></td>
				<td><a href='/tasks/{{ $task->id }}'>{{ $task->name }}</a></td>
				<td><a href='/users/{{ $project->owner->id }}'>{{ $task->assigned->name }}</a></td>
				<td>{{ $task->status->name }}</td>
				<td>{{ $task->created_at }}</td>
				<td>
					<a href='/tasks/{{ $task->id }}/edit' class='btn btn-warning'>
						Edit
					</a>
					<a href='/tasks/{{ $task->id }}/delete' class='btn btn-danger'>
						Delete
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@stop
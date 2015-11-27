@extends('layout')

@section('breadcrumbs')
<li>Projects</li>
@stop

@section('content')

	<div class='row'>
		<div class='col-md-6'>
			<h2>Projects list</h2>
		</div>
		<div class='col-md-6 text-right'>
			<p>
				<a href='/projects/create' class='btn btn-success' style='margin-top: 13px;'>Create a new project</a>
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
				<td>Created date</td>
				<td>Actions</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($projects as $project)
			<tr>
				<td>{{ $project->id }}</td>
				<td><a href='/users/{{ $project->owner->id }}'>{{ $project->owner->name }}</a></td>
				<td><a href='/projects/{{ $project->id }}'>{{ $project->name }}</a></td>
				<td>{{ $project->created_date }}</td>
				<td>
					<a href='/projects/{{ $project->id }}/edit' class='btn btn-warning'>
						Edit
					</a>
					@if ($project->owner->id == Auth::id())
					<a href='/projects/{{ $project->id }}/delete' class='btn btn-danger'>
						Delete
					</a>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@stop
@extends('layout')

@section('breadcrumbs')
<li><a href="/projects/{{ $task->project->id }}">{{ $task->project->name}}</a></li>
<li>{{$task->name}}</li>
@stop

@section('content')

	<div class='row'>
		<div class='col-md-6'>
			<h2>Task view</h2>
		</div>
	</div>

	<table class='table table-bordered table-hover'>
		<tbody>
			<tr>
				<td style='font-weight: bold;'>Task name:</td>
				<td>{{ $task->name }}</td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Owner:</td>
				<td><a href='/users/{{ $task->owner->id }}'>{{ $task->owner->name }}</a></td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Project:</td>
				<td><a href='/projects/{{ $task->project->id }}'>{{ $task->project->name }}</a></td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Assigned:</td>
				<td><a href='/users/{{ $task->assigned->id }}'>{{ $task->assigned->name }}</a></td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Status:</td>
				<td>{{ $task->status->name }}</td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Created at:</td>
				<td>{{ $task->created_at }}</td>
			</tr>
			<tr>
				<td style='font-weight: bold;'>Updated at:</td>
				<td>{{ $task->updated_at }}</td>
			</tr>
			<tr>
				<td colspan='2'>
					<b>Description:</b><br>
					{!! $task->description !!}</td>
				</tr>
			</tr>
		</tbody>
	</table>

	<table class='table table-bordered table-hover'>
		<thead>
			<tr>
				<td>Log date</td>
				<td>Description</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($task->log as $log)
			<tr>
				<td>{{ $log->log_date }}</td>
				<td>{!! $log->description !!}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@stop
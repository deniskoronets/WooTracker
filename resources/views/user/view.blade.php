@extends('layout')

@section('content')

	<div class='row'>
		<div class='col-md-6'>
			<h2>User info</h2>
		</div>
	</div>
	<table class='table table-hover table-border'>
		<tbody>
			<tr>
				<td>Name</td>
				<td>{{ $user->name }}</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>{{ $user->email }}</td>
			</tr>
			<tr>
				<td>Created date</td>
				<td>{{ $user->created_at }}</td>
			</tr>
			<tr>
				<td>Updated date</td>
				<td>{{ $user->updated_at }}</td>
			</tr>
		</tbody>
	</table>

@stop
@extends('layout')

@section('content')

	@if (count($errors) > 0)
	    <div class='alert alert-danger'>
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

	<script src="//cdn.ckeditor.com/4.5.4/standard/ckeditor.js"></script>

	<div class='row'>
		<div class='col-lg-8'>
			<form action='' method='post'>
				{!! csrf_field() !!}
				<div class='form-group'>
					<label>Task name</label>
					<input type='text' name='name' class='form-control' value='{{ old('name') ?: $task->name }}'>
				</div>
				<div class='form-group'>
					<label>Description</label>
					<textarea name='description' class='form-control' rows='10'>{{ old('description') ?: $task->description }}</textarea>
				</div>
				<div class='form-group'>
					<label>Assigned</label>
					<input type='text' name='assigned_id' class='form-control' value='{{ old('assigned_id') ?: $task->assigned_id }}'>
				</div>
				<div class='form-group'>
					<label>Status</label>
					<input type='text' name='status_id' class='form-control' value='{{ old('status_id') ?: $task->status_id }}'>
				</div>
				<input type='submit' class='btn btn-success' value='Edit'>
			</form>
		</div>
	</div>
	<script>
        CKEDITOR.replace('description');
    </script>

@stop
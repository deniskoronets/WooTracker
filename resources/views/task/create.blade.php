@extends('layout')

@section('breadcrumbs')
<li><a href='/projects'>Projects</a></li>
<li><a href='/projects/{{ $project->id }}/'>{{ $project->name }}</a></li>
<li>Create task</li>
@stop

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
					<input type='text' name='name' class='form-control' value='{{ old('name') }}'>
				</div>
				<div class='form-group'>
					<label>Description</label>
					<textarea name='description' class='form-control' rows='10'>{{ old('description') }}</textarea>
				</div>
				<div class='form-group'>
					<label>Assigned</label>
					<select name='assigned_id' class='form-control'>
						@foreach ($users as $user)
						<option value='{{ $user->id }}'>{{ $user->name }} ({{ $user->email }})</option>
						@endforeach
					</select>
				</div>
				<div class='form-group'>
					<label>Status</label>
					<select name='status_id' class='form-control'>
						@foreach ($statuses as $status)
						<option value='{{ $status->id }}'>{{ $status->name }}</option>
						@endforeach
					</select>
				</div>
				<div class='form-group'>
					<label>Labels</label>
					<div>
						@foreach ($labels as $label)
						<a class='btn btn-xs task-label' style='color: {{ $label->text_color }}; background-color: {{ $label->color }}'>
							<input type='checkbox' name='label[{{$label->id }}]' style='float: left; position: relative; top: -2px; margin-right: 5px;'>
							{{ $label->name }}
						</a>
						@endforeach
					</div>
				</div>
				<input type='submit' class='btn btn-success' value='Create'>
			</form>
		</div>
	</div>

@stop

@section('javascript')
<script>
	CKEDITOR.replace('description');

	$('.task-label').click(function(e) {

		if ($(e.target).is('input[type=checkbox]')) return;

		checkbox = $(this).find('input[type=checkbox]');

		checkbox.prop('checked', !checkbox.prop('checked'));
	})
</script>
@stop
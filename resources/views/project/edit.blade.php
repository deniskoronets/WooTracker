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
					<label>Project name</label>
					<input type='text' name='name' class='form-control' value='{{ old('name') ?: $project->name }}'>
				</div>
				<input type='submit' class='btn btn-success' value='Create'>
			</form>
		</div>
	</div>
	<script>
        CKEDITOR.replace('description');
    </script>

@stop
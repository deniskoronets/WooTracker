@extends('layout')

@section('content')

	@if (count($errors) > 0)
	    <div>
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

	<div class='row'>
		<div class='col-lg-6 col-lg-offset-3'>
			<form action='' method='post'>
				{{ csrf_field() }}
				<div class='form-group'>
					<label>Email</label>
			    	<input type='text' name='email' value='{{ old('email') }}' class='form-control'>
		    	</div>
		    	<div class='form-group'>
		    		<label>Password</label>
		    		<input type='password' name='password' value='{{ old('password') }}' class='form-control'>
	    		</div>
	    		<input type='submit' value='Sign in' class='btn btn-success'>
			</form>
		</div>
	</div>
@stop
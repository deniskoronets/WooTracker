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

	<form action='/auth/register' method='post'>
		{!! csrf_field() !!}
		<input type='text' name='name' value='{{ old('name') }}'>
		<input type='text' name='login' value='{{ old('login') }}'>
		<input type='password' name='password' value='{{ old('password') }}'>
		<input type='password' name='password_confirmation' value='{{ old('password_confirmation') }}'>
		<input type='email' name='email' value='{{ old('email') }}'>
		<input type='submit'>
	</form>
@stop
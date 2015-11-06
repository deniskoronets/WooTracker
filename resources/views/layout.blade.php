<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>@yield('title')</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://getbootstrap.com/examples/jumbotron/jumbotron.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">WooTracker</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          	@section('auth')
          	@if (!Auth::guest())
          	<div class='navbar-form navbar-right' style='color: white;'>
          		Hello, <b>{{ Auth::user()->name }}</b>!<br>
          		{{ Auth::user()->email }} <a href='/auth/logout'>Logout</a>
      		</div>
          	@else
			<form class="navbar-form navbar-right" action="/auth/login" method="post">
				{{ csrf_field() }}
				<div class="form-group">
					<input type="text" placeholder="Email" class="form-control">
				</div>
				<div class="form-group">
					<input type="password" placeholder="Password" class="form-control">
				</div>
				<button type="submit" class="btn btn-success">Sign in</button>
			</form>
          	@endif
          	@show
        </div>
      </div>
    </nav>

    @section('shows-jumbotron')
    <div class="jumbotron">
      <div class="container">
      	@section('jumbotron')
	        @include('company-info')
        @show
      </div>
    </div>
    @show

    <div class="container">

		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			@section('breadcrumbs')
			<li><a href="/">Some page</a></li>
			@show
		</ol>

		@if (Session::has('success'))
			<div class="alert alert-success">{{ Session::get('success') }}</div>
		@endif

		@if (Session::has('error'))
			<div class="alert alert-danger">{{ Session::get('success') }}</div>
		@endif

  		@yield('content')

		<hr>

		<footer>
			<p>&copy; WooTracker {{ date('Y') }}</p>
		</footer>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    @section('javascript')
    @show
  </body>
</html>
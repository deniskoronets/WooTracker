@extends('layout')

@section('breadcrumbs')
	<li><a href='/admin'>Admin</a></li>
	<li>Dashboard</li>
@stop

@section('content')

	<style>
	.admin-element {
		border: 1px solid #eee;
		background: #f2f2f2;
		padding: 20px;
		border-radius: 10px;
	}
	.admin-element h3 {
		margin-top: 0px;
	}
	.row.admin-elements-row {
		margin-bottom: 20px;
	}
	</style>

	<h2>Hello, Admin!</h2>
	<div class='row admin-elements-row'>
		<div class='col-lg-6'>
			<div class='admin-element'>
				<h3><a href='/admin/projects'>Projects</a></h3>
				<p>Allows you to edit projects on site. Also settings block enabled</p>
			</div>
		</div>
		<div class='col-lg-6'>
			<div class='admin-element'>
				<h3><a href='/admin/users'>Users</a></h3>
				<p>Allows you to manage users. You can grant some access, make moderators</p>
			</div>
		</div>
	</div>
	<div class='row admin-elements-row'>
		<div class='col-lg-6'>
			<div class='admin-element'>
				<h3><a href='/admin/labels'>Labels</a></h3>
				<p>Allows you to edit projects on site. Also settings block enabled</p>
			</div>
		</div>
		<div class='col-lg-6'>
			<div class='admin-element'>
				<h3><a href='/admin/statuses'>Statuses</a></h3>
				<p>Allows you to manage users. You can grant some access, make moderators</p>
			</div>
		</div>
	</div>
@stop
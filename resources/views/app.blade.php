<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TRACKING SYSTEM</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<![endif]-->


	<link href="{{ asset('/js/fastselect.min.css') }}" rel="stylesheet">
	<script src="{{ asset('/js/fastselect.standalone.js') }}"></script>


	<style>

		.fstElement { font-size: 1.2em; }
		.fstToggleBtn { min-width: 16.5em; }

		.submitBtn { display: none; }

		.fstMultipleMode { display: block; }
		.fstMultipleMode .fstControls { width: 100%; }

	</style>


</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
 			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
 				<?php
					if(Entrust::hasRole('Admin')) {
					?>
					<ul class="nav navbar-nav">
						<li><a href="{{ url('/') }}">Home</a></li>
						<li><a href="{{ url('/department') }}">Department</a></li>
						<li><a href="{{ url('/project_view') }}">Project</a></li>
						<li><a href="{{ url('/users') }}">Users</a></li>
						<li><a href="{{ url('/modulecreation') }}">Module</a></li>
						<li><a href="{{ url('/addtask') }}">Task</a></li>
						<li><a href="{{ url('/timesheet') }}">Timesheet</a></li>
					</ul>
					<?php }?>
					<?php
					if(Entrust::hasRole('User')) {
					?>
					<ul class="nav navbar-nav">
						<li><a href="{{ url('/') }}">Home</a></li>
 						<li><a href="{{ url('/modulecreation') }}">Module</a></li>
						<li><a href="{{ url('/addtask') }}">Task</a></li>
						<li><a href="{{ url('/timesheet') }}">Timesheet</a></li>
					</ul>
					<?php }?>
					<?php
					if(Entrust::hasRole('Project Lead')) {
					?>
					<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url('/department') }}">Department</a></li>
					<li><a href="{{ url('/project_view') }}">Project</a></li>
					<li><a href="{{ url('/users') }}">Users</a></li>
					<li><a href="{{ url('/modulecreation') }}">Module</a></li>
					<li><a href="{{ url('/addtask') }}">Task</a></li>
					<li><a href="{{ url('/timesheet') }}">Timesheet</a></li>
					</ul>
					<?php }?>
					<?php
					if(Entrust::hasRole('Project Manager')) {
					?>
					<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url('/department') }}">Department</a></li>
					<li><a href="{{ url('/project_view') }}">Project</a></li>
					<li><a href="{{ url('/users') }}">Users</a></li>
					<li><a href="{{ url('/modulecreation') }}">Module</a></li>
					<li><a href="{{ url('/addtask') }}">Task</a></li>
					<li><a href="{{ url('/timesheet') }}">Timesheet</a></li>
					</ul>
					<?php }?>

    				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/homes') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#dept_tbl').DataTable();
			$('#users').DataTable();
			$('#userview').DataTable();
		});
	</script>
</body>
</html>

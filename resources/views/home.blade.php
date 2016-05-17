@extends('app')

@section('content')
	<style>
		.fstElement { font-size: 0.8em; }
		.fstToggleBtn { min-width: 16.5em; }

		.submitBtn { display: none; }

		.fstMultipleMode { display: block; }
		.fstMultipleMode .fstControls { width: 100%; }
	</style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">User Register</div>
					<div class="panel-body">
						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<strong>Whoops!</strong> There were some problems with your input.<br><br>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<form class="form-horizontal" role="form" method="POST" action="{{ url('/create') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-group">
								<label class="col-md-4 control-label">User Name<span style="color: red" >&nbsp; <b>*</b></span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="username" value="{{ old('username') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">First Name<span style="color: red" >&nbsp; <b>*</b></span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Last Name<span style="color: red" >&nbsp; <b>*</b></span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">E-Mail Address<span style="color: red" >&nbsp; <b>*</b></span></label>
								<div class="col-md-6">
									<input type="email" class="form-control" name="email" value="{{ old('email') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Password<span style="color: red" >&nbsp; <b>*</b></span></label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="password">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Confirm Password<span style="color: red" >&nbsp; <b>*</b></span></label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="password_confirmation">
								</div>
							</div>
							<div>
								<label class="col-md-4 control-label">Gender</label>
								<div class="col-md-6">
									<input type="radio" name="gender"
										   <?php if (isset($gender) && $gender=="male") echo "checked";?>
										   value="male">Male
									<input type="radio" name="gender"
										   <?php if (isset($gender) && $gender=="female") echo "checked";?>
										   value="female">Female
								</div>
							</div>
							<br><br>
							<div>
								<label class="col-md-4 control-label">Date of Birth</label>
								<div class="col-md-6">
									<input  class="dobpicker" name="dob" value="{{old('dob')}}" placeholder="YY-MM-DD">
									<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
 								</div>
								<br><br>
							</div>

							<div>
								<br>
								<label class="col-md-4 control-label">Joining Date</label>
								<div class="col-md-6">
									<input  class="jodpicker" name="jod" value="{{old('jod')}}" placeholder="YY-MM-DD">
									<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
 								</div>
								<br><br>
							</div>
							<br>
							<div class="form-group">
								<label class="col-md-4 control-label">Roles</label>
								<div class="col-md-6">
									<select  class="multipleSelect" name="roles">
										<?php $roles_list=\App\Role::get();
										foreach($roles_list as $roles){?>
										<option value="{{$roles->id}}">
											{{$roles->name}}
										</option>
										<?php }
										?>
									</select>
									<script>
										$('.multipleSelect').fastselect();
									</script>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label">Department Name<span style="color: red" >&nbsp; <b>*</b></span></label>
								<div class="col-md-6">
									<select  class="departSelect" multiple name="user_depart_name[]">
										<?php $depart_list=\App\Department::get();
										foreach($depart_list as $depart){?>
										<option value="{{$depart->id}}">
											{{$depart->name}}
										</option>
										<?php }
										?>
									</select>
									<script>
										$('.departSelect').fastselect();
									</script>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Submit
									</button>
									<button type="reset" class="btn btn-default">Reset</button>
									<a class="btn btn-default" href="{{  url('users') }}">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
  		$(".dobpicker").datepicker({ dateFormat: 'yy-mm-dd' });
  		$(".jodpicker").datepicker({ dateFormat: 'yy-mm-dd' });

	</script>



@endsection

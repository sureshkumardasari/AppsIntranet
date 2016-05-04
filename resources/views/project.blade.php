@extends('app')
@section('content')
	<script>
 		$('.multipleSelect').fastselect();
 	</script>
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
					<div class="panel-heading">Project</div>
					<div class="panel-body">
						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<strong>Whoops!</strong> There were some problems with your input.<br><br>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
										{{--<li>{{ $error->first('description','<li>:message</li>') }}</li>--}}
									@endforeach
								</ul>
							</div>
						@endif

						<form class="form-horizontal" role="form" method="POST" action="{{ url('/project_submit') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-group">
								<label class="col-md-4 control-label">Project Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="name" value="{{ old('pro_name') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Project Description</label>
								<div class="col-md-6">
									<textarea class="form-control" name="description" value="{{ old('pro_description') }}"></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Department Name</label>
								<div class="col-md-6">
									<select  class="multipleSelect" multiple name="user_depart_name[]">
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
								<label class="col-md-4 control-label">Add Users</label>
								<div class="col-md-6">
									<select class="multipleSelect" multiple name="userids[]">
									<?php $user_list=\App\User::get();
										foreach($user_list as $user){?>
										<option value="{{$user->id}}">
											{{$user->first_name}}
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

							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Submit
									</button>
									<button type="reset" class="btn btn-default">Reset</button>
									<a class="btn btn-default" href="{{  url('project_view') }}">Cancel</a>
								</div>
							</div>
							@if(Session::has('success'))
								<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
							@endif
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

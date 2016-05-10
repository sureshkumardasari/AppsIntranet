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
									@endforeach
								</ul>
							</div>
						@endif

						<form class="form-horizontal" role="form" method="POST" action="{{ url('/project_submit') }}">
							<input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">

							<div class="form-group">
								<label class="col-md-4 control-label">Project Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="name" value="{{ old('name') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Project Description</label>
								<div class="col-md-6">
									<textarea class="form-control" name="description" value="">{{ old('description') }}</textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Department Name</label>
								<div class="col-md-6">
									<select  id="depart" class="departSelect" multiple onchange="change_depart()" name="user_depart_name[]">
										<?php $depart_list=\App\Department::get();
										foreach($depart_list as $depart){?>
										<option value="{{$depart->id}}">
											{{$depart->name}}
										</option>
										<?php }
										?>
									</select>
									<script>
										$('#depart').fastselect();
									</script>
								</div>
							</div>
							<div class="form-group" >
								<label class="col-md-4 control-label">Add Project Lead</label>
								<div class="col-md-6" id="projectleads">
									<select class="leadSelect form-control" multiple name="lead[]" id="lead">


									</select>
									<script>
									//	$('.leadSelect').multiselect();
									</script>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Add Project Manager</label>
								<div class="col-md-6">
									<select class="managerSelect form-control" multiple name="manager[]" id="manager">


									</select>
									<script>
										//$('.managerSelect').fastselect();
									</script>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Add Users</label>
								<div class="col-md-6">
									<select class="userSelect form-control" multiple name="user[]" id="user">

									</select>
									<script>
										//$('.userSelect').fastselect();
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
	<script>
		var count=0;


		function change_depart(){
			//	alert($('#depart').val());
			var csrf=$('Input#csrf_token').val();
			//var lead=$('#lead');
			$.ajax(
					{

						headers: {"X-CSRF-Token": csrf},
						url:'userlist_project/'+$('#depart').val(),
						type:'post',
						success:function(response){
							var a = response.length;
							//alert(a);
							var i=0;
							if(a!=0){
								$('#lead').empty();
								$('#user').empty();
								$('#manager').empty();
								for(i=0;i<a;i++) {
									if (response[i].role_id == 2) {
										var o = new Option( response[i].first_name , response[i].id);
										$('#user').append(o);
									}
									else if (response[i].role_id == 3) {
										var o = new Option( response[i].first_name , response[i].id);
										$('#lead').append(o);
									}
									else if (response[i].role_id == 4) {
										var o = new Option(response[i].first_name, response[i].id);
										$('#manager').append(o);
									}
								}
							}
							else{
								$('#lead').empty();
								$('#user').empty();
								$('#manager').empty();
							}



						}
					}
			)
		}
	</script>
@endsection

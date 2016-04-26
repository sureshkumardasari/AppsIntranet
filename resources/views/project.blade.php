@extends('app')
@section('content')
	<script>

		$('.multipleInputDynamicWithInitialValue').fastselect();
		$.ajax({
			dataType: "json",
			url: '/user_list',
			data: data,
			success: success
		});
	</script>
	<style>
		.fstElement { font-size: 1.2em; }
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
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-group">
								<label class="col-md-4 control-label">Project Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="pro_name" value="{{ old('pro_name') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Project Description</label>
								<div class="col-md-6">
									<textarea class="form-control" name="pro_description" value="{{ old('pro_description') }}"></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Department Name</label>
								<div class="col-md-6">
									<select  name="user_depart_name">
										<?php $depart_list=\App\Department::get();
										foreach($depart_list as $depart){?>
										<option>
											{{$depart->name}}
										</option>
										<?php }
										?>
									</select>
								</div>
							</div>


							<div class="form-group">
								<label class="col-md-4 control-label">Add Users</label>
								<div class="col-md-6">
									<input
											type="text"
											multiple
											class="multipleInputDynamicWithInitialValue"
  											data-url="{{ url('/user_list') }}"
{{--											data-url="{{ asset('/js/data.json') }}"--}}

											name="language"
									/>
									<script>

										$('.multipleInputDynamicWithInitialValue').fastselect();

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

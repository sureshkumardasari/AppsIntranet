@extends('app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Department</div>
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

						<form class="form-horizontal" role="form" method="POST" action="{{ url('/department_submit') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-group">
								<label class="col-md-4 control-label">Department Name<span style="color: red" >&nbsp; <b>*</b></span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="name" value="{{ old('name') }}">

								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Description<span style="color: red" >&nbsp; <b>*</b></span></label>
								<div class="col-md-6">
									<textarea class="form-control" name="depart_description" value="">{{ old('depart_description') }}</textarea>

								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Submit
									</button>
									<button type="reset" class="btn btn-default">Reset</button>
									<a class="btn btn-default" href="{{  url('department') }}">Cancel</a>
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
.

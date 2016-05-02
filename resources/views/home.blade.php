@extends('app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Home</div>

					<div class="panel-body">

					</div>
					{{-- <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                         <ul class="nav navbar-nav">
                             <li><a href="{{ url('/userslist') }}">Users List</a></li>
                             <li><a href="{{ url('/department') }}">Department List</a></li>
                             <li><a href="{{ url('/project') }}">Project List</a></li>
                         </ul>
        </div>--}}
					<div class="row">
						<div class="col-lg-12">

							<div class="row">
								<div class="col-lg-6">
									<h2>List of Users </h2>
								</div>
								<div class="col-lg-6">
									<a class="btn btn-success pull-right" name="new user" href="{{ url('') }}">Add New User</a>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
									<tr>
										<th>UserName</th>
										<th>Email</th>
										<th>Project Name</th>
										<th>Department</th>
										<th>Status</th>
										<th>Created At</th>
										<th>Actions</th>
									</tr>
									</thead>
									<tbody>
									@if($users)
										@foreach($users as $user)
											<tr>
												<td>{{ $user->username }}</td>
												<td>{{ $user->email }}</td>
												<td>{{ $user->department_id }}</td>
												<td>{{ $user->department_id }}</td>
												<td>{{ $user->status == 'A'?'Active':'Inactive' }}</td>
												<td>{{ $user->created_at }}</td>
												<td><a href="{{ url('/users/edit/'.$user->id) }}" >Edit</a>
													&nbsp;&nbsp;|&nbsp;&nbsp;
													<a href="{{ url('home/delete/'.$user->id) }}" onclick="return confirm('Are you sure you want delete this user ?');">Delete</a>
													&nbsp;&nbsp;|&nbsp;&nbsp;
													<a href="{{ url('/users/profile/'.$user->id) }}" >Profile</a>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td colspan="4">No Records Found !</td>
										</tr>
									@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div>
		@yield('content')
	</div>
@endsection
@extends('app')


@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a class="btn btn-success pull-right" name="new user" href="{{ url('auth/register') }}">Create New User</a>
                    <div class="panel-heading">Users List

                    </div>
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
                        <form class="form-horizontal" role="form" method="get" action="{{ url('department/{id}/edit') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <table class="table table-bordered table-hover table-striped" id="userview">
                                    <thead>
                                    <tr>
                                        <th>UserName</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                         <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($user)
                                        @foreach($user as $users)
                                            <tr>
                                                <td>{{ $users->username }}</td>
                                                <td>{{ $users->email }}</td>
                                                <td>{{ $users->status == 'A'?'Active':'Inactive' }}</td>
                                                 <td><a href="{{ url('/users/edit/'.$users->id) }}" >Edit</a>
                                                    &nbsp;&nbsp;|&nbsp;&nbsp;
                                                    <a href="{{ url('users/delete/'.$users->id) }}" onclick="return confirm('Are you sure you want delete this user ?');">Delete</a>
                                                  {{--  <a href="{{ url('/users/profile/'.$users->id) }}" >Profile</a>--}}
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
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
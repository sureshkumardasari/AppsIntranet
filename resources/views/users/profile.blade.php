@extends('app')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Profile{{--  <a class="btn btn-primary pull-right" href="{{  url('/home') }}">Back to Home</a>
                    </div>
--}}    </div>
                    <div class="panel-body">

                    </div>
                  {{--  <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>UserName</th>
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
                                        <td>{{ $user->department_id }}</td>
                                        <td>{{ $user->department_id }}</td>

                                        <td>{{ $user->created_at }}</td>

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
                </div>--}}

</div>
    </div>
    </div>
    </div>

@endsection

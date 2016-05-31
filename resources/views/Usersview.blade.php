@extends('app')


@section('content')

    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a class="btn btn-success pull-right" name="new user" href="{{ url('auth/register') }}">Create New User</a>
                    <div class="panel-heading">Users List</div>
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
                                    <th>Role</th>
                                    <th>Department</th>
                                    <th>Project</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($users)
                                    <?php $i=0;$j=0;?>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->username }}</td>
                                            <td>{{$user->role_name}}</td>

                                            <td>
                                                <div id="mydropdown" class="dropdown">
                                                    <a href="#" class=" dropdown-toggle"  id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        department list
                                                        <span class="caret"></span>
                                                    </a>
                                                    <ul style="list-style: none;" class="dropdown-menu" aria-labelledby="dropdownMenu2">

                                                        @foreach($departments[$j++] as $department)
                                                            <li >{{$department->depart_name}}</li>
                                                        @endforeach

                                                    </ul>
                                                </div>

                                            </td>
                                            <td>
                                                <div id="mydropdown" class="dropdown">
                                                    <a href="#" class=" dropdown-toggle"  id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        projects list
                                                        <span class="caret"></span>
                                                    </a>
                                                    <ul style="list-style: none;" class="dropdown-menu" aria-labelledby="dropdownMenu2">

                                                            @foreach($projects[$i++] as $project)
                                                                <li >{{$project->project_name}}</li>
                                                            @endforeach

                                                    </ul>
                                                </div>

                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td> <?php
                                                if(($user->user_status)=='0')
                                                {
                                                ?>
                                                <a href="{{url('/status/'.$user->user_id)}}"
                                                   class="act" onclick="return confirm('Activate <?php echo $user->user_name?>');"> Deactivate </a>
                                                <?php
                                                }
                                                if(($user->user_status)=='1')
                                                {
                                                ?>
                                                <a href="{{url('/status/'.$user->user_id)}}"
                                                   class="deact" onclick="return confirm('De-activate <?php echo $user->user_name?>');"> Activate</a>
                                                <?php
                                                }
                                                ?></td>
                                            <td><a href="{{ url('/users/edit/'.$user->user_id) }}" >Edit</a>
                                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                                <a class="confirm" href="javascript:;" data-ref="{{ url('users/delete/'.$user->user_id) }}" >Delete</a>
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
                    <div>

                        @if(Session::has('flash_message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! Session('flash_message') !!}</em></div>
                        @endif
                    </div>
                    <div>

                        @if(Session::has('flash_message_failed'))
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span><em> {!! Session('flash_message_failed') !!}</em></div>
                        @endif
                    </div>


                </div>
                <div> <a class="btn btn-primary pull-left" name="new user" href="{{ url('users/exportcsv') }}">Export CSV</a></div>
            </div>
        </div>
    </div>
    <script>
        $('document').ready(function(){
           $('.dropdown-projects').click(function(){
//               $(this) > ('.dropdown-projects-content').css('display','block');
               $(".dropdown-projects-content > div").css('display','block');
               //$('.dropdown-projects-content').css('display','block');
           });
        });
        function abc(){
            //$('this')(.dropdown-projects-content').show();
        }
        //----------
        $('.dropdown-projects').on({
            "click":function(e){
                e.stopPropagation();
            }
        });
    </script>
    <script type="text/javascript" src="{{ asset('/js/confirm.js')}}"></script>
@endsection
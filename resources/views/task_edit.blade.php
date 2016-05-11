@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" >Task Edit</div>
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
                        <form class="form-horizontal" role="form" method="post" action="{{url('taskupdate',$task->id)}}">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">


                            <div class="form-group">
                                <label class="col-md-4 control-label">Task Title:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="task_title" value="{{$task->task_title}}" readonly/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Task Description:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="task_description" >{{$task->task_description}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">User:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <select  class="form-control user" name="user_id" >
                                        <option disabled selected hidden>select</option>
                                        @foreach($users as $user)
                                            <option value={{$user->id}}>{{$user->username}}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Date:</label>
                                <div class="col-md-2">
                                    <input  class="form-control datepicker" name="date" value="{{$task->date}}" placeholder="select date">
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <a class="btn btn-default" href="{{  url('task') }}">Cancel</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
    </script>


@endsection
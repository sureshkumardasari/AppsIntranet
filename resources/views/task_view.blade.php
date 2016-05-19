@extends('app')
@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                <a class="btn btn-success pull-right" name="back" href="{{  url('task') }}">Back</a>
                    <div class="panel-heading" >Task View</div>
                    
                        <form class="form-horizontal" role="form" method="post" action="{{url('task/{id}/viewlog',$task->id)}}">
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
                            <table class="table" id="timesheet1">
                        <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Module Name</th>
                            <th>Task Title</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Hours Spent</th>
                          
                        </tr>

                        </thead>
                        <tbody id="data">
                        @foreach($timesheet as $time)
                            <tr><td>
                                    {{$time->project_name}}
                                </td>
                                <td>
                                    {{$time->module_name}}
                                </td>
                                <td>
                                    {{$time->task_title}}
                                </td>
                                <td>
                                    {{$time->created_at}}
                                </td>
                                <td>
                                    {{$time->updated_at}}
                                </td>
                                <td>
                                    {{$time->hours.":".$time->minutes}}
                                </td>
                              
                            </tr>
                        @endforeach
                        </tbody>
                    </table>



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

@endsection
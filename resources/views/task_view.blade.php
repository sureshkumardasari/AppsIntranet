@extends('app')
@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                <a class="btn btn-success pull-right" name="back" href="{{  url('task') }}">Back</a>
                    <div class="panel-heading" >Task View</div>
                    
                        <form class="form-horizontal" role="form" method="post" action="{{url('task/{id}/viewlog',$creat[0]->id)}}">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Project Name:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="project_name" value="{{$creat[0]->project_name}}" readonly/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Module Name:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="module_name" value="{{$creat[0]->module_name}}" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Task Title:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="task_title" value="{{$creat[0]->task_title}}" readonly/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Task Description:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="task_description" readonly>{{$creat[0]->task_description}}</textarea>
                                </div>
                            </div>
                        @foreach($timesheet as $time)
                        <div class="panel panel-default">
                            <div class="container">
                                    <br>
                                    <label class="col-md-1 control-label">User:</label>
                                    <div class="col-md-2">
                                        <label class="form-control" name="task_description" value="">{{$time->username}}</label>
                                    </div>



                                    <label class="col-md-2 control-label">Updated At:</label>
                                    <div class="col-md-2">
                                        <label class="form-control" name="task_description" value="">{{$time->updated_at}}</label>
                                    </div>



                                    <label class="col-md-1 control-label">Status:</label>
                                    <div class="col-md-2">
                                        <label class="form-control" name="task_description" value="">{{
                                        <?php
                                    @if($time->status==0)
                                        completed
                                    @elseif($time->status==1)
                                        pending
                                    @elseif($time->status==2)
                                        started
                                    @elseif($time->status==3)
                                        need clarification
                                    @endif
                                    ?>
                                    }}
                                        </label>
                                    </div>

                            </div>
                            <br>
                            <br>
                            <div class="container">
                                <label class="col-md-1 control-label">Comment:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="task_description" readonly>{{$time->comment}}</textarea>
                                </div>
                                <label class="col-md-1 control-label">Time Spent:</label>
                                <div class="col-md-2">
                                    <label class="form-control" name="task_description" value="">{{$time->hours.":".$time->minutes}}</label>
                                </div>
                            </div>
                            <br>
                        </div>
                        @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

@endsection
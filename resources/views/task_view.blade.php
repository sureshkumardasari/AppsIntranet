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
                                <div class="col-md-6" align="right">
                                    Project Name:
                                </div>
                                <div class="col-md-6" >
                                    {{$creat[0]->project_name}}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6" align="right">
                                    Module Name:
                                </div>
                                <div class="col-md-6" >
                                    {{$creat[0]->module_name}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6" align="right">
                                    Task Title:
                                </div>
                                <div class="col-md-6" >
                                    {{$creat[0]->task_title}}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6" align="right">
                                    Task Description:
                                </div>
                                <div class="col-md-6" >
                                    {{$creat[0]->task_description}}
                                </div>
                            </div>
                        @foreach($timesheet as $time)
                        <div class="panel panel-default">
                            <div class="container">
                                    <br>
                                    <label class="col-md-1 " align="right">User:</label>
                                    <div class="col-md-2">
                                        {{$time->username}}
                                    </div>



                                    <label class="col-md-2 " align="right">Updated At:</label>
                                    <div class="col-md-2">
                                       {{$time->updated_at}}
                                    </div>



                                    <label class="col-md-1 " align="right">Status:</label>
                                    <div class="col-md-2">
                                    @if($time->status==0)
                                        completed
                                    @elseif($time->status==1)
                                        pending
                                    @elseif($time->status==2)
                                        started
                                    @elseif($time->status==3)
                                        need clarification
                                    @endif
                                    </div>

                            </div>
                            <br>
                            <br>
                            <div class="container">
                                <label class="col-md-1 " align="right">Comment:</label>
                                <div class="col-md-6">
                                   <i>{{$time->comment}}</i>
                                </div>
                                <label class="col-md-1 " align="right">Time Spent:</label>
                                <div class="col-md-2">
                                   {{$time->hours.":".$time->minutes}}
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
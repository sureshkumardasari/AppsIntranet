@extends('app')


@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a class="btn btn-success pull-right" name="new user" href="{{ url('addtask') }}">Create A New Task</a>
                    <div class="panel-heading">Task List

                    </div>

                    <form class="form-horizontal" role="form" method="get" action="{{ url('task/{id}/edit') }}">
                        <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">

                        <div class="panel-heading col-md-6"><b>Please Select a Project</b>
                            <select name="status" id="projectlist"  class='form-control' onchange="project_change()">
                                <option value="0">--Select All--</option>
                                <?php
                                foreach($projects as $project){?>
                                <option value="{{$project->id}}">
                                    {{$project->name}}
                                </option>
                                <?php }
                                ?>
                            </select>
                        </div>

                     <div class="panel-heading col-md-6"><b>Please Select Task Status In the Drop-Down</b>
                         <select name="status" id="status"  class='form-control' onchange="status_change()">
                            <option value="4">Select All</option>
                             <option value="0">Open</option>
                             <option value="1">In progress</option>
                             <option value="2">Need Clarification</option>
                             <option value="3">Completed</option>
                        </select>
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


                    </div>
                        <div id="taskList">
                            {!! $tasklist !!}
                        </div>
                         <div>
 @if(!$tasks->isEmpty())
                <a href="#"><button class="btn btn-info" onclick="download_excel();">Download Excel</button></a>
            @endif
            </div>

                 </form>
                </div>
                <div>
                    @if(Session::has('message'))
                        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! Session('message') !!}</em></div>
                    @endif
                </div>
                <div>
                    @if(Session::has('alert-class'))
                        <div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span><em> {!! Session('alert-class') !!}</em></div>
                    @endif
                </div>
            </div>
        </div>
        </div>
       
    <script>

        function status_change(){
            var csrf=$('Input#csrf_token').val();
             $.ajax(
                    {

                        headers: {"X-CSRF-Token": csrf},
                        url:'task/'+$('#projectlist').val()+'/'+$('#status').val(),
                        type:'post',
                         success:function(response){
                            $('#taskList').empty();
                            $('#taskList').append(response);


                         }

                    }
            )
        }

        function project_change(){

            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {

                        headers: {"X-CSRF-Token": csrf},
                        url:'taskList_project/'+$('#projectlist').val(),
                        type:'post',
                        success:function(response){
                            $('#taskList').empty();
                            $('#taskList').append(response);

                        }
                    }
            )

        }

    </script>


@endsection
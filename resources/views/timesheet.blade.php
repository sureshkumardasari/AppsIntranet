@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">timesheet</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="timesheetsubmit">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">select project:</label>

                                    <div class="col-md-4">
                                    <select name="project_id" class="project form-control" onchange="refresh_module();">
                                        <option>Select Project</option>
                                        @foreach($projects as $project)
                                            <option value={{$project->id}}>{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                        <span class="text-danger">{{ $errors->first('project_id') }}</span>

                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">select module:</label>

                                    <div class="col-md-4">
                                    <select name="module_id" id="moduleList"  class='col-md-6 form-control' onchange="refresh_task();">
                                        <span class="text-danger">{{ $errors->first('module_id') }}</span>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">select Task:</label>
                            <div class="col-md-4">
                                <select name="task_id" class='form-control' id="taskList"></select>
                                <span class="text-danger">{{ $errors->first('taskList') }}</span>

                            </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" >Comments:</label>
                            <div class="col-md-4">
                                    <textarea name="comment" class='form-control' name="comment">{{old('comment')}}</textarea>
                                <span class="text-danger">{{ $errors->first('comment') }}</span>

                            </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Status:</label>
                            <div class="col-md-4">
                                    <select name="status" class='form-control'>
                                        <option selected disabled hidden>--please select status--</option>
                                        <option value="0">complete</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Started</option>
                                        <option value="3">Need Clarification</option>
                                    </select>
                                <span class="text-danger">{{ $errors->first('status') }}</span>

                            </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Time Spent:</label>
                                <div class="col-md-4">
                                    <ul style="list-style: none" >
                                        <li style="display: inline">
                                            <input type="number" class='form-control' name="hours" max="12" min="0" size="2" placeholder="Enter Hours">
                                            <span class="text-danger">{{ $errors->first('hours') }}</span>

                                        </li>
                                        <li style="display: inline">
                                            <input  type="number"  class='form-control' name="minutes" min="0" max="60" placeholder="Enter Minutes">
                                            <span class="text-danger">{{ $errors->first('minutes') }}</span>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-4">
                                    <button type="submit" class="form-control btn btn-primary">submit</button>
                                </div>
                            </div>
                        </form>
                        @if(Session::has('success'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
                        @endif
                        @if(Session::has('error'))
                            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        function refresh_module(){
            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {
                        headers: {"X-CSRF-Token": csrf},
                        url:'modulelist/'+$('.project').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                             $('#moduleList').empty();
                            var opt=new Option('select module','');
                            //opt.addClass('selected','disabled','hidden');
                            $('#moduleList').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].name,response[i].id);
                                $('#moduleList').append(opt);
                            }
                        }
                    }
            )


        }

        function refresh_task(){
            var csrf=$('Input#csrf_token').val();

            $.ajax(
                    {
                        headers: {"X-CSRF-Token": csrf},
                        url:'tasklist/'+$('.project').val()+'/'+$('#moduleList').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                             $('#taskList').empty();
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].task_title,response[i].id);
                                $('#taskList').append(opt);
                            }
                        }
                    }
            )

        }
    </script>

@stop
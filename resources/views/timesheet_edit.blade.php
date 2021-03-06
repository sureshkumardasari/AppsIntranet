@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit TimeSheet</div>
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

                        <form class="form-horizontal" role="form" method="post" action="{{url('timesheet_update')}}">
                            <input type="hidden" name="timesheet_id" value="{{$data->id}}">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Project:</label>

                                <div class="col-md-4">
                                    <input type="text" name="project_id" class="project form-control" value={{$project->name}} readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Module:</label>
                                <div class="col-md-4">
                                    <input type="text" name="module_id" id="moduleList"  class='col-md-6 form-control' readonly value={{$module_name}}  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Task:</label>
                                <div class="col-md-4">
                                    <input type="text" name="task_id" class='form-control' id="taskList" value={{$task->task_title}} readonly>
                                    <input type="hidden" name="taskid" value={{$task_id}}>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Comments:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-4">
                                    <textarea name="comment" class='form-control' name="comment">{{$data->comment}}</textarea>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Status:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-4">
                                    <select name="status" id="status" class='form-control'>
                                        <option selected disabled hidden>--please select status--</option>
                                        <option value="0">Open</option>
                                        <option value="1">In progress</option>
                                        <option value="2">Need Clarification</option>
                                        <option value="3">Completed</option>
                                    </select>


                                </div>
                            </div>
                            <div>
                                <label class="col-md-4 control-label">Date:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <input  class="datepicker" name="date" value="{{$data->date}}" placeholder="YY-MM-DD">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                                <br><br>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Time Spent:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-4">
                                    <ul style="list-style: none" >
                                        <li style="display: inline">
                                            <input type="number" class='form-control' name="hours" max="12" min="0" size="2" placeholder="Enter Hours" value="{{$data->hours}}">

                                        </li>
                                        <li style="display: inline">
                                            <input  type="number"  class='form-control' name="minutes" min="0" max="60" placeholder="Enter Minutes" value="{{$data->minutes}}">

                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <a class="btn btn-default" href="{{  url('timesheet_display') }}">Cancel</a>
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
    $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
    $(document).ready(function(){
                $('#status').val({{$data->status }});
            }
    );

</script>


@stop
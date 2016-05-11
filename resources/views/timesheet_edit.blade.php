@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit TimeSheet</div>
                    <div class="panel-body">
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
                                    <input type="text" name="module_id" id="moduleList"  class='col-md-6 form-control' value={{$module->name}} readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Task:</label>
                                <div class="col-md-4">
                                    <input type="text" name="task_id" class='form-control' id="taskList" value={{$task->task_title}} readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Comments:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-4">
                                    <textarea name="comment" class='form-control' name="comment">{{$data->comment}}</textarea>
                                    <span class="text-danger">{{ $errors->first('comment') }}</span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Status:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-4">
                                    <select name="status" id="status" class='form-control'>
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
                                <label class="col-md-4 control-label">Time Spent:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-4">
                                    <ul style="list-style: none" >
                                        <li style="display: inline">
                                            <input type="number" class='form-control' name="hours" max="12" min="0" size="2" placeholder="Enter Hours" value="{{$data->hours}}">
                                            <span class="text-danger">{{ $errors->first('hours') }}</span>
                                        </li>
                                        <li style="display: inline">
                                            <input  type="number"  class='form-control' name="minutes" min="0" max="60" placeholder="Enter Minutes" value="{{$data->minutes}}">
                                            <span class="text-danger">{{ $errors->first('minutes') }}</span>
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
    $(document).ready(function(){
                $('#status').val({{$data->status }});
            }
    );

</script>


@stop
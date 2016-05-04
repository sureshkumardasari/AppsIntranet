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
                                <label class="col-md-4 control-label">project:</label>

                                <div class="col-md-4">
                                    <input type="text" name="project_id" class="project form-control" value={{$project->name}} readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">module:</label>

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
                                <label class="col-md-4 control-label">Comments:</label>
                                <div class="col-md-4">
                                    <textarea name="comment" class='form-control'>{{$data->comment}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Status:</label>
                                <div class="col-md-4">
                                    <select name="status" id="status" class='form-control'>
                                        <option selected disabled hidden>--please select status--</option>
                                        <option value="0">complete</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Started</option>
                                        <option value="3">Need Clarification</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Time Spent:</label>
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
                                <div class="col-md-2 col-md-offset-4">
                                    <button type="submit" class="form-control btn btn-primary">update</button>
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
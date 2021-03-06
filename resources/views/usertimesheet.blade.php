@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">TimeSheet</div>
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
                        <form class="form-horizontal" role="form" method="post" action="timesheetsubmit">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">


                            <div class="form-group">
                                <label class="col-md-4 control-label">Select User:<span style="color: red" >&nbsp; <b>*</b></span></label>

                                <div class="col-md-4">
                                    <select name="user_id" id="user" class="user form-control" onchange="status_change();">
                                        <option disabled selected hidden>--Select User--</option>
                                        @foreach($users as $user)
                                            <option value={{$user->id}}>{{$user->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-md-4 control-label">Select Project:<span style="color: red" >&nbsp; <b>*</b></span></label>

                                <div class="col-md-4">
                                    <select name="project_id" id="projectlist" class="project form-control" onchange="refresh_project();">
                                        <option disabled selected hidden>--Select Project--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Select Module:</label>

                                <div class="col-md-4">
                                    <select name="module_id" id="moduleList"  class='module form-control' onchange="refresh_task();">
                                        <option disabled selected hidden>--Select Module--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Select Task:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-4">
                                    <select name="task_id" class="task form-control" id="taskList">
                                        <option disabled selected hidden>--Select Task--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" >Comments:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-4">
                                    <textarea name="comment" class='form-control' name="comment">{{old('comment')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Status:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-4">
                                    <select name="status" class='form-control'>
                                        <option selected disabled hidden>--Select Status--</option>
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
                                    <input  class="datepicker" name="date" value="{{old('date')}}" placeholder="YY-MM-DD">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                                <br><br>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Time Spent:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-2">

                                            <input type="number" class='form-control' name="hours" max="12" min="0" size="2" placeholder="Hours">
                                </div>
                                <div class="col-md-2">
                                            <input  type="number"  class='form-control' name="minutes" min="0" max="60" placeholder="Minutes">

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
        $('.datepicker').datepicker();
        function status_change(){
            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {

                        headers: {"X-CSRF-Token": csrf},
                        url:'UsersTimesheet/'+$('#user').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            $('#projectlist').empty();
                            var opt=new Option('--Select Project--','');
                            //opt.addClass('selected','disabled','hidden');
                            $('#projectlist').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].name,response[i].id);
                                $('#projectlist').append(opt);
                            }
                        }

                    }
            )
        }

        function refresh_project(){

            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {

                        headers: {"X-CSRF-Token": csrf},
                        url:'modulelist/'+$('#projectlist').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            $('#moduleList').empty();
                            var opt=new Option('--Select Module--','');
                            //opt.addClass('selected','disabled','hidden');
                            $('#moduleList').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].name,response[i].id);
                                $('#moduleList').append(opt);
                            }
                        }
                    }
            )
            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {

                        headers: {"X-CSRF-Token": csrf},
                        url:'taskList/'+$('#projectlist').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            $('#taskList').empty();
                            var opt=new Option('--Select Task--','');
                            //opt.addClass('selected','disabled','hidden');
                            $('#taskList').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].task_title,response[i].id);
                                $('#taskList').append(opt);
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
                        url:'tasklist/'+$('.project').val()+'/'+$('.module').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            $('#taskList').empty();
                            var opt=new Option('--Select Task--','');
                            //opt.addClass('selected','disabled','hidden');
                            $('#taskList').append(opt);
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
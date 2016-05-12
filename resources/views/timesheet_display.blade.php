@extends('app')
@section('content')
    <?php $now=date('Y-m-d');
    // dd($now);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align:center; "> TimeSheet</div>
                    <div class="panel-body">


                        <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Department:</label>
                                <div class="col-md-2">
                                    <select name="depart_id" class='form-control' id="department" onchange="refresh_projects_users();">
                                        <option value="0" selected >--department filter--</option>
                                        @foreach($department_list as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">project:</label>
                                <div class="col-md-2">
                                    <select name="project_id" class='form-control' id="project" onchange="refresh_module();">
                                        {{--<option value="0" selected >--project filter--</option>--}}
                                        {{--@foreach($project_list as $project)--}}
                                            {{--<option value="{{$project->id}}">{{$project->name}}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">module:</label>
                                <div class="col-md-2">
                                    <select name="module_id" class='form-control' id="moduleList" onchange="refresh_task();">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Task:</label>
                                <div class="col-md-2">
                                    <select name="task_id" class='form-control' id="task" onchange="users();">
                                        {{--<option value="0" selected >--Task filter--</option>--}}
                                        {{--@foreach($project_list as $project)--}}
                                            {{--<option value="{{$project->id}}">{{$project->name}}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>
                            </div>
                            </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="col-md-1 control-label">User:</label>
                                <div class="col-md-2">
                                    <select name="user_id" class='form-control' id="user">
                                        {{--<option value="0" selected >--User filter--</option>--}}
                                        {{--@foreach($project_list as $project)--}}
                                            {{--<option value="{{$project->id}}">{{$project->name}}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">From:</label>
                                <div class="col-md-2">
                                    <input class="form-control date" name="from_date" placeholder="From date" id="from_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">To:</label>
                                <div class="col-md-2">
                                    <input class="form-control date" name="to_date" placeholder="To date" id="to_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-1"></div>
                                <button onclick="filter();">filter</button>
                            </div>
                        </div>

                    </div>

                    <table class="table" id="timesheet">
                        <thead>
                        <tr>
                            <th>project name</th>
                            <th>module name</th>
                            <th>task title</th>
                            <th>created at</th>
                            <th>updated at</th>
                            <th>hours spent</th>
                            <th>status</th>
                            <th>action</th>
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
                                <input type="hidden" id="url" value="{{url('timesheet_edit/')}}">
                                <td>@if($time->status==0)
                                        completed
                                    @elseif($time->status==1)
                                        pending
                                    @elseif($time->status==2)
                                        started
                                    @elseif($time->status==3)
                                        need clarification
                                    @endif
                                </td>
                                <td>
                                    <?php
                                    $date=date('Y-m-d',strtotime($time->created_at));
                                        ?>
                                    @if($now==$date)
                                        <a href="{{url('timesheet_edit/'.$time->timesheet_id) }}">edit</a>

                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if(!$timesheet->isEmpty())
                <a href="#"><button class="btn btn-info" onclick="download_excel();">Download Excel</button></a>
                @endif
            </div>
        </div>
    </div>
    </div>
    <script>
        $('.date').datepicker({ dateFormat: 'yy-mm-dd' });
        //project filter
        function refresh_projects_users(){

            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {
                        headers: {"X-CSRF-Token": csrf},
                        url:'project_list/'+$('#department').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            // alert(a);
                            $('#project').empty();
                            $('#moduleList').empty();
                            $('#task').empty();
                            var opt=new Option('--project filter--','0');
                            //opt.addClass('selected','disabled','hidden');
                            $('#project').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].name,response[i].id);
                                $('#project').append(opt);
                            }
                        }
                    }
            )
            users();

        }

        //function for getting the list of users
        function users(){
            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {
                        headers: {"X-CSRF-Token": csrf},
                        url:'userlist/'+$('#department').val()+'/'+$('#project').val()+'/'+$('#task').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            // alert(a);
                            $('#user').empty();
                            var opt=new Option('--user filter--','0');
                            //opt.addClass('selected','disabled','hidden');
                            $('#user').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].first_name,response[i].id);
                                $('#user').append(opt);
                            }
                        }
                    }
            )
        }
        //module filter
        function refresh_module(){
            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {
                        headers: {"X-CSRF-Token": csrf},
                        url:'modulelist/'+$('#project').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            // alert(a);
                            $('#moduleList').empty();
                            $('#task').empty();
                            var opt=new Option('--module filter--','0');
                            //opt.addClass('selected','disabled','hidden');
                            $('#moduleList').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].name,response[i].id);
                                $('#moduleList').append(opt);
                            }
                        }
                    }
            );
            users();

        }
        //function for filtering tasks

        function refresh_task(){
            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {
                        headers: {"X-CSRF-Token": csrf},
                        url:'tasklist/'+$('#project').val()+'/'+$('#moduleList').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            // alert(a);
                            $('#task').empty();
                            var opt=new Option('--task filter--','0');
                            //opt.addClass('selected','disabled','hidden');
                            $('#task').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].task_title,response[i].id);
                                $('#task').append(opt);
                            }
                        }
                    }
            );
users();

        }
        //function for filtering the data..

        function filter(){
            var csrf=$('Input#csrf_token').val();
            var department=$('#department').val();
            var project=$('#project').val();
            var module=$('#moduleList').val();
            var task=$('#task').val();
            var user=$('#user').val();
            var from_date=$('#from_date').val();
            var to_date=$('#to_date').val();
            var data={'department':department,'project':project,'module':module,'task':task,'user':user,'from_date':from_date,'to_date':to_date};
            if(department==0&&(project==0||project==null) ){
                var url="timesheet_display";
                ajax(url,data,csrf);
//                $.ajax(
//                        {
//                            url:'timesheet_display',
//                            headers:{"X-CSRF-Token":csrf},
//                            type:"post",
//                            success:function(response){
//                                //alert(response);
//                                var length=response.length;
//                                //alert(length);
//                                var data;
//                                if(length==0){
//                                    $('#data').html("--no data to display---");
//                                }
//                                else {
//                                    for (i = 0; i < length; i++) {
//                                        data += "<tr><td>" + response[i].project_name + "</td><td>" + response[i].module_name + "</td><td>" + response[i].task_title + "</td><td>" + response[i].created_at + "</td><td>" + response[i].updated_at + "</td><td>"+response[i].hours+":"+response[i].minutes+"</td><td>"+response[i].status+"</td><td></td></tr>";
//                                    }
//                                    $('#data').html(data);
//                                }
//                            }
//                        }
//                );
            }
            else {
                var url="gettimesheetfilterdata";
                ajax(url,data,csrf);
            }
        }
        function ajax(url,data,csrf){
            $.ajax(
                    {
                        url:url,
                        headers: {"X-CSRF-Token": csrf},
                        type:"post",
                        data:data,
                        success:function(response){
                            var length=response.length;
                            var data= new Array();
                            if(length==0){
                                $('#timesheet').dataTable().fnClearTable();
                                $('#timesheet').dataTable().fnDraw();

                            }
                            else {
                                var  now = new Date();
                                now=now.getUTCFullYear()+""+now.getUTCMonth()+""+now.getUTCDate();
                                for (i = 0; i < length; i++) {
                                    data[i]=new Array();
                                    data[i].push(response[i].project_name, response[i].module_name , response[i].task_title ,  response[i].created_at , response[i].updated_at , response[i].hours+":"+response[i].minutes);

                                    //to print the status of the task..
                                    if(response[i].status==0)
                                        status="complete";
                                    else if(response[i].status==1)
                                        status="pending";
                                    else if(response[i].status==2)
                                        status="started";
                                    else if(response[i].status==3)
                                        status="Need Clarification";
                                    data[i].push(status);

                                    //comparing todays date with the created_at date to provide edit links..
                                    var date=new Date(response[i].created_at.replace(/-/g, "/"));
                                    date=date.getFullYear()+""+date.getMonth()+""+date.getDate();
                                    if(date==now){
                                        data[i].push("<a href='timesheet_edit/"+ response[i].timesheet_id +"'>edit</a>");
                                    }
                                    else{
                                        data[i].push(" ");
                                    }
                                }
                                $('#timesheet').dataTable().fnClearTable();
                                $('#timesheet').dataTable().fnAddData(data);
                                $('#timesheet').dataTable().fnDraw();
                            }
                        }

                    }
            );
        }
        function download_excel(){
            var url="downloadExcelfortimesheet/xls";
            var csrf=$('Input#csrf_token').val();
            var department=$('#department').val();
            var project=$('#project').val();
            var module=$('#moduleList').val();
            var task=$('#task').val();
            var user=$('#user').val();
            var from_date=$('#from_date').val();
            var to_date=$('#to_date').val();
            //var object ={};
            //var array_data=[];
            object = {'department':department,'project':project,'module':module,'task':task,'user':user,'from_date':from_date,'to_date':to_date};
            //array_data.push(object);
            array_data=JSON.stringify(object);
            window.location =""+url+"?data="+array_data;
//            $.ajax(
//                    {
//                url:url,
//                        headers: {"X-CSRF-Token": csrf},
//                        type:"get",
//                        data:data,
//                        success:function(response){
//
//                        }
//
//
//
//            }
//            );
        }
    </script>

@stop
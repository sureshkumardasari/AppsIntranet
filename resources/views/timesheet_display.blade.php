@extends('app')
@section('content')
    <?php $now=date('Y-m-d');
    // dd($now);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align:center; "> TimeSheet</div>
                    <div class="panel-body">


                        <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <div class="col-md-4">
                                <select name="project_id" class='form-control' id="project" onchange="refresh_module();">
                                    <option value="0" selected >--project filter--</option>
                                    @foreach($project_list as $project)
                                        <option value="{{$project->id}}">{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">

                                <select name="module_id" class='form-control' id="moduleList">

                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <button onclick="filter();">filter</button>
                        </div>
                    </div>


                    <table class="table">
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
                <a href="{{ URL::to('downloadExcelfortimesheet/csv') }}"><button class="btn btn-info">Download CSV</button></a>
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
                        url:'modulelist/'+$('#project').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            // alert(a);
                            $('#moduleList').empty();
                            var opt=new Option('--module filter--','0');
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

        function filter(){
            var csrf=$('Input#csrf_token').val();
            var project=$('#project').val();
            var module=$('#moduleList').val();
            var data={'project':project,'module':module};
            if(project==0){
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
            else{
                var url="gettimesheetfilterdata";
                ajax(url,data,csrf);
//            $.ajax(
//                    {
//                        url:'gettimesheetfilterdata',
//                        headers: {"X-CSRF-Token": csrf},
//                        type:"post",
//                        data:{'project':project, 'module': module},
//                        success:function(response){
//                            //alert(response);
//                            var length=response.length;
//                            //alert(length);
//                            var data;
//                            if(length==0){
//                                $('#data').html("--no data to display---");
//                            }
//                            else {
//                                now = new Date();
//                                for (i = 0; i < length; i++) {
//                                    data += "<tr><td>" + response[i].project_name + "</td><td>" + response[i].module_name + "</td><td>" + response[i].task_title + "</td><td>" + response[i].created_at + "</td><td>" + response[i].updated_at + "</td><td>"+response[i].hours+":"+response[i].minutes+"</td><td>";
//
//                                    //to print the status of the task..
//                                    if(response[i].status==0)
//                                            status="complete";
//                                    else if(response[i].status==1)
//                                    status="pending";
//                                    else if(response[i].status==2)
//                                    status="started";
//                                    else if(response[i].status==3)
//                                    status="Need Clarification";
//                                    data +=status+"</td>";
//
//                                    //comparing todays date with the created_at date to provide edit links..
//
//                                    if(response[i].created_at==now)
//                                    data +="<td>edit</td></tr>";
//                                    else
//                                        data +="<td>view</td></tr>";
//
//                                }
//                                $('#data').html(data);
//                            }
//                        }
//
//                    }
//            );
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
                            var data;
                            if(length==0){
                                $('#data').html("--no data to display---");
                            }
                            else {
                                var  now = new Date();
                                now=now.getUTCFullYear()+""+now.getUTCMonth()+""+now.getUTCDate();
                                for (i = 0; i < length; i++) {
                                    data += "<tr><td>" + response[i].project_name + "</td><td>" + response[i].module_name + "</td><td>" + response[i].task_title + "</td><td>" + response[i].created_at + "</td><td>" + response[i].updated_at + "</td><td>"+response[i].hours+":"+response[i].minutes+"</td><td>";

                                    //to print the status of the task..
                                    if(response[i].status==0)
                                        status="complete";
                                    else if(response[i].status==1)
                                        status="pending";
                                    else if(response[i].status==2)
                                        status="started";
                                    else if(response[i].status==3)
                                        status="Need Clarification";
                                    data +=status+"</td>";

                                    //comparing todays date with the created_at date to provide edit links..
                                    var date=new Date(response[i].created_at.replace(/-/g, "/"));
                                    date=date.getFullYear()+""+date.getMonth()+""+date.getDate();
                                    if(date==now){
//                                            alert(response[i].timesheet_id);
                                        //var url= $('#url').val();
                                         data +="<td><a href='"+ "timesheet_edit/" + ''+response[i].timesheet_id +"'>edit</a></td></tr>";
                                    }
                                     else
                                        data +="<td></td></tr>";

                                }
                                $('#data').html(data);
                            }
                        }

                    }
            );
        }
    </script>

@stop
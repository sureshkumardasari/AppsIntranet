@extends('app')
@section('content')
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
                                    <option value="0" selected hidden disabled>--project filter--</option>
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
            $.ajax(
                    {
                        url:'gettimesheetfilterdata',
                        headers: {"X-CSRF-Token": csrf},
                        type:"post",
                        data:{'project':project, 'module': module},
                        success:function(response){
                            //alert(response);
                            var length=response.length;
                            //alert(length);
                            var data;
                            if(length==0){
                                $('#data').html("--no data to display---");
                            }
                            else {
                                for (i = 0; i < length; i++) {
                                    data += "<tr><td>" + response[i].project_name + "</td><td>" + response[i].module_name + "</td><td>" + response[i].task_title + "</td><td>" + response[i].created_at + "</td><td>" + response[i].updated_at + "</td></tr>";
                                }
                                $('#data').html(data);
                            }
                        }

                    }
            );
        }
    </script>

@stop
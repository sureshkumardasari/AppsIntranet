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
                                        <option value="0" selected >-Select-</option>
                                        @foreach($department_list as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Project:</label>
                                <div class="col-md-2">
                                    <select name="project_id" class='form-control' id="project" onchange="refresh_module();">
                                        <option value="0" selected >-Select-</option>
                                        {{--<option value="0" selected >--project filter--</option>--}}
                                        {{--@foreach($project_list as $project)--}}
                                        {{--<option value="{{$project->id}}">{{$project->name}}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Module:</label>
                                <div class="col-md-2">
                                    <select name="module_id" class='form-control' id="moduleList" onchange="refresh_task();">
                                        <option value="0" selected >-Select-</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Task:</label>
                                <div class="col-md-2">
                                    <select name="task_id" class='form-control' id="task" onchange="users();">
                                        <option value="0" selected >-Select-</option>
                                        {{--<option value="0" selected >--Task filter--</option>--}}
                                        {{--@foreach($project_list as $project)--}}
                                        {{--<option value="{{$project->id}}">{{$project->name}}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="col-md-1 control-label">User:</label>
                                <div class="col-md-2">
                                    <select name="user_id" class='form-control' id="user">
                                        <option value="0" selected >-Select-</option>
                                        {{--<option value="0" selected >--User filter--</option>--}}
                                        {{--@foreach($project_list as $project)--}}
                                        {{--<option value="{{$project->id}}">{{$project->name}}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="col-md-1 control-label">From:</label>
                                <div class="col-md-2">
                                    <input class="form-control date" name="from_date" placeholder="From date" id="from_date">
                                </div>
                                <div class="col-md-1">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div >
                                <label class="col-md-1 control-label">To:</label>
                                <div class="col-md-2">
                                    <input class="form-control date" name="to_date" placeholder="To date" id="to_date">
                                </div>
                                <div class="col-md-1">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-1"></div>
                                <button onclick="filter();">Filter</button>
                            </div>
                        </div>
                        <div class="form-group" id="advanced_filter_group">
                            <div class="form-group">
                                <input  type="checkbox" name="advanced_filter" id="advanced_filter" value="1" onchange="advanced_filters();"><label class="control-label"> Advanced filters</label>
                            </div>
                            <script>

                                function advanced_filters(){
                                    if($('#advanced_filter').is(':checked') ){
                                        $('#advancedfiltersdiv').show();
                                        $('#monthly_or_weekly_filter_div').show();
                                        if($('#monthly').is(':checked')){
                                            $('#week_filter_div').hide();
                                        }
                                        else if($('#weekly').is(':checked')){
                                            $('#week_filter_div').show();
                                        }
                                    }
                                    else {
                                        $('#advancedfiltersdiv').hide();
                                    }
                                }
                                function weekly_div_hide(){
                                    $('#week_filter_div').hide();
                                }
                                function weekly_div_show(){
                                    $('#week_filter_div').show();
                                }
                            </script>
                            <div id="advancedfiltersdiv">
                                <div class="form-group">
                                    <div  id="monthly_or_weekly_filter_div">
                                        <input type="radio" name="monthly_or_weekly_filter" id="monthly" value="monthly" checked onchange="weekly_div_hide();"><label>monthly</label>&nbsp
                                        <input type="radio" name="monthly_or_weekly_filter" id="weekly" value="weekly" onchange="weekly_div_show();"><label>weekly</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div  id="week_filter_div">
                                        <label class="col-md-1 control-label" align="right"> Week:</label>
                                        <div class="col-md-2" >
                                            <select class="form-control" name="adv_week_filter" id="adv_week_filter">
                                                <option value="1">First week</option>
                                                <option value="2">Second week</option>
                                                <option value="3">Third week</option>
                                                <option value="4">Fourth week</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="col-md-1 control-label" align="right"> Month</label>
                                    <div class="col-md-2" id="month_filter_div">
                                        <select class="form-control" id="adv_month_filter" name="adv_month_filter">

                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>

                                    <label class="col-md-1 control-label" align="right"> Year:</label>
                                    <div class="col-md-2">
                                        <?php
                                        $presentyear=date('Y');

                                        ?>
                                        <input class="form-control" type="number" id="adv_filter_year" name="excel_year_filter" value="{{$presentyear}}" max="{{$presentyear}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <table class="table" id="timesheet">
                    <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Module Name</th>
                        <th>Task Title</th>
                        <th>Task Created At</th>
                        <th>Task Updated At</th>
                        <th>Hours Spent</th>
                        <th>Status</th>
                        <th>Action</th>
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
        $('#advanced_filter_group').hide();
        $('#advancedfiltersdiv').hide();

        $('.date').datepicker({ dateFormat: 'yy-mm-dd' });
        //project filter
        function refresh_projects_users(){
            if($('#department').val()!=0){
                $('#advanced_filter_group').show();}
            else {
                $('#advanced_filter').attr('checked', false);
                $('#advancedfiltersdiv').hide();
                    $('#advanced_filter_group').hide();
            }
            var csrf=$('Input#csrf_token').val();
            $.ajax(
                    {
                        headers: {"X-CSRF-Token": csrf},
                        url:'project_list/'+$('#department').val(),
                        type:'post',
                        success:function(response){
                            var a=response.length;
                            $('#project').empty();
                            $('#moduleList').empty();
                            $('#task').empty();
                            $('#from_date').val('');
                            $('#to_date').val('');
                            var opt=new Option('-Select-','0');
                            $('#project').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].name,response[i].id);
                                $('#project').append(opt);
                            }
                        }
                    }
            );
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
                            $('#from_date').val('');
                            $('#to_date').val('');
                            var opt=new Option('-Select-','0');
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
                            $('#moduleList').empty();
                            $('#from_date').val('');
                            $('#to_date').val('');
                            var opt=new Option('-Select-','0');
                            $('#moduleList').append(opt);
                            for(i=0;i<a;i++){
                                var opt=new Option(response[i].name,response[i].id);
                                $('#moduleList').append(opt);
                            }
                        }
                    }
            );
            users();
            refresh_task();

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
                            $('#from_date').val('');
                            $('#to_date').val('');
                            var opt=new Option('-Select-','0');
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
            //if($('#advanced_filter').is(':checked') ){
            var adv_filter_type= $('#advanced_filter').is(':checked')?($('#weekly').is(':checked')?"weekly":"monthly"):null;
            var adv_year=$('#advanced_filter').is(':checked')?$('#adv_filter_year').val():null;
            var adv_month=$('#advanced_filter').is(':checked')?$('#adv_month_filter').val():null;
            var adv_week= ($('#advanced_filter').is(':checked')) ? (($('#weekly').is(':checked')?$('#adv_week_filter').val():null)) :null;
            // }


            // var advanced=$('#advanced_filter').val();
            var csrf=$('Input#csrf_token').val();
            var department=$('#department').val();
            var project=$('#project').val();
            var module=$('#moduleList').val();
            var task=$('#task').val();
            var user=$('#user').val();
            var from_date=$('#from_date').val();
            var to_date=$('#to_date').val();
            var data={'department':department,'project':project,'module':module,'task':task,'user':user,'from_date':from_date,'to_date':to_date,'adv_filter_type':adv_filter_type,'adv_year':adv_year,'adv_month':adv_month,'adv_week':adv_week};
            if(department==0&&(project==0||project==null) ){
                var url="timesheet_display";
                ajax(url,data,csrf);
//
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
            var adv_filter_type= $('#advanced_filter').is(':checked')?($('#weekly').is(':checked')?"weekly":"monthly"):null;
            var adv_year=$('#advanced_filter').is(':checked')?$('#adv_filter_year').val():null;
            var adv_month=$('#advanced_filter').is(':checked')?$('#adv_month_filter').val():null;
            var adv_week= $('#advanced_filter').is(':checked')?($('#weekly').is(':checked')?$('#weekly').val():null):null;
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
            object = {'department':department,'project':project,'module':module,'task':task,'user':user,'from_date':from_date,'to_date':to_date,'adv_filter_type':adv_filter_type,'adv_year':adv_year,'adv_month':adv_month,'adv_week':adv_week};
            //array_data.push(object);
            array_data=JSON.stringify(object);
            window.location =""+url+"?data="+array_data;
        }
    </script>

@stop
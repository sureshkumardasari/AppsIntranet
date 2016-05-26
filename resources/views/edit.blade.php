@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Project Edit</div>
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

                        <form class="form-horizontal" role="form" method="post" action="{{  url('update/'.$projects->id) }}">
        {{--{!! Form::DB($departments, array('route' => array('crud.departments.update', $departments->id), 'method' => 'PUT')) !!}--}}

                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Project Name<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{$projects->name }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Project Description<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description" value="">{{ $projects->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Department Name<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <select  id="depart" class="departSelect" multiple onchange="change_depart()" name="user_depart_name[]">
                                        <?php $depart_list=\App\Department::get();
                                        foreach($depart_list as $depart){?>
                                        <option value="{{$depart->id}}">
                                            {{$depart->name}}
                                        </option>
                                        <?php }
                                        ?>
                                    </select>
                                    <script>
                                        $('#depart').multiselect();
                                    </script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Client</label>

                                <div class="col-md-6">
                                    <select  id="client" class="clientSelect"  name="client">
                                        <option value="0">select client</option>
                                        <?php $clients=\App\Client::get();
                                        foreach($clients as $client_data){?>
                                        <option value="{{$client_data->id}}">
                                            {{$client_data->clientname}}
                                        </option>
                                        <?php }
                                        ?>
                                    </select>
                                    <script>
                                       // $('#client').multiselect();
                                    </script>
                                </div>
                            </div>


                            <div class="form-group" >
                                <label class="col-md-4 control-label">Add Project Lead</label>
                                <div class="col-md-6" id="projectleads">
                                    <select class="leadSelect form-control" multiple name="lead[]" id="lead">
                                        @foreach($project_leads as $project_lead)
                                            <option value="{{$project_lead->id}}" selected>{{$project_lead->first_name}}</option>
                                            @endforeach
                                    </select>
                                    <script>
                                        //	$('.leadSelect').multiselect();
                                    </script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Add Project Manager</label>
                                <div class="col-md-6">
                                    <select class="managerSelect form-control" multiple name="manager[]" id="manager">
                                        @foreach($project_managers as $project_manager)
                                            <option value="{{$project_manager->id}}" selected >{{$project_manager->first_name}}</option>
                                        @endforeach

                                    </select>
                                    <script>
                                      //  $('.managerSelect').multiselect();
                                    </script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Add Users</label>
                                <div class="col-md-6">
                                    <select class="userSelect form-control" multiple name="user[]" id="user">
                                        @foreach($project_users as $project_user)
                                            <option value="{{$project_user->id}}" selected>{{$project_user->first_name}}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                       // $('.userSelect').multiselect();
                                    </script>
                                </div>
                            </div>





                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <a class="btn btn-default" href="{{  url('project_view') }}">Cancel</a>
                                </div>
                            </div>
                            @if(Session::has('success'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
                            @endif
    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $list=Array();
    foreach($departments as $department){
        array_push($list,$department->depart_id);
    }




    ?>
    <script>
        //var count=0;

        $('#depart').val(<?php echo "[";
                foreach($list as $li)
                    echo $li.",";
                echo "0]"?>);
            $('#depart').multiselect("refresh");



        $('#client').val({{$client->client_id}});

        function change_depart(){
            //	alert($('#depart').val());
            var csrf=$('Input#_token').val();
            //var lead=$('#lead');
            var url="{{url('userlist_project')}}";
            $.ajax(
                    {

                        headers: {"X-CSRF-Token": csrf},
                        url:url+'/'+$('#depart').val(),
                        type:'post',
                        success:function(response){
                            var a = response.length;
                            //alert(a);
                            var i=0;
                            if(a!=0){
                                $('#lead').empty();
                                $('#user').empty();
                                $('#manager').empty();
                                for(i=0;i<a;i++) {
                                    if (response[i].role_id == 2) {
                                        var o = new Option( response[i].first_name , response[i].id);
                                        $('#user').append(o);
                                    }
                                    else if (response[i].role_id == 3) {
                                        var o = new Option( response[i].first_name , response[i].id);
                                        $('#lead').append(o);
                                    }
                                    else if (response[i].role_id == 4) {
                                        var o = new Option(response[i].first_name, response[i].id);
                                        $('#manager').append(o);
                                    }
                                }
                            }
                            else{
                                $('#lead').empty();
                                $('#user').empty();
                                $('#manager').empty();
                            }



                        }
                    }
            )
        }
    </script>
@endsection

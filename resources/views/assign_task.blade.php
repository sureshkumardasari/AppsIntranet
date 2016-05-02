@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" style=" background-color:pink;color:green;text-align:center;">User Task Assignment</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="{{url('/addtask')}}">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Project:</label>
                                <div class="col-md-6">
                                    <select  class="form-control project" name="project_id" onchange="refresh_module();">
                                        <option disabled selected hidden>select</option>
                                        @foreach($projects as $project_list)
                                            <option value={{$project_list->id}}>{{$project_list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Module:</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="module_id" id="moduleList"></select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Task Title:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="task_title" value="{{old('task_title')}}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Task Description:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="task_description" >{{old('task_description')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">User:</label>
                                <div class="col-md-6">
                                    <select  class="form-control user" name="user_id">
                                        <option disabled selected hidden>select</option>
                                        @foreach($users as $user)
                                            <option value={{$user->id}}>{{$user->username}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Date:</label>
                                <div class="col-md-2">
                                    <input  class="form-control datepicker" name="date" value="{{old('date')}}" placeholder="select date">
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-6">
                                    <button type="submit" class="btn btn-primary" role='button' name="submit"> submit</button>
                                </div>

                            </div>
                            <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                                    @if(Session::has('fail'))
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <p style=" color: red; text-align:center">{{ Session::get('fail') }}</p>
                                        @elseif(Session::has('success'))
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <p style=" text-align:center">{{ Session::get('success') }}</p>
                                    @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $('.datepicker').datepicker();
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
                         for(i=0;i<a;i++){
                            var opt=new Option(response[i].name,response[i].id);
                             $('#moduleList').append(opt);
                        }
                      }
                 }
        )


    }
</script>


@endsection
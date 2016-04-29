@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" style=" background-color:pink;color:green;text-align:center;">user tasks</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="{{url('/addtask')}}">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">User:</label>
                                <div class="col-md-6">
                                    <select  class="form-control user" name="user_id" onchange="refresh_project();">
                                        <option disabled selected hidden>select</option>
                                        @foreach($users as $user)
                                            <option value={{$user->id}}>{{$user->username}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Project:</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="project_id" id="projectlist"></select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Description:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description" >{{old('description')}}</textarea>
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
    function refresh_project(){
var csrf=$('Input#csrf_token').val();
        //alert($('.user').val());
        $.ajax(
                {
                    headers: {"X-CSRF-Token": csrf},
                    url:'projectlist/'+$('.user').val(),
                    type:'post',
                    success:function(response){
                       // var a=JSON.stringify(response);
                        var a=response.length;
                       // alert(a);
                        $('#projectlist').empty();
                        //alert( $('#projectlist')[0].options.length);
                        for(i=0;i<a;i++){
                            var opt=new Option(response[i].name,response[i].id);
                            $('#projectlist').append(opt);

                        }
                        //alert( $('#projectlist')[0].options.length);
                       // alert(response[0].id);
                    }
                    //data:{id:1}
                }
        )


    }
</script>


@endsection
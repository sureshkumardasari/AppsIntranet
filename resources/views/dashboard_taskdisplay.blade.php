@extends('app')


@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a class="btn btn-success pull-right" name="new user" href="{{ url('addtask') }}">Create A New Task</a>
                    <div class="panel-heading">Task List

                    </div>

                    <form class="form-horizontal" role="form" method="get" action="{{ url('task/{id}/edit') }}">
                        <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                     <div class="panel-heading"><b>Please Select Task Status In the Drop-Down</b>

                        <select name="status" id="status"  class='form-control' onchange="status_change()">
                            <option selected disabled hidden>--please select status--</option>
                            <option value="0">Completed task</option>
                            <option value="1">Pending Task</option>
                            <option value="2">Started Task</option>
                            <option value="3">Need Clarification</option>
                            <option value="4">Select All</option>
                        </select>

                    </div>
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


                    </div>
                        <div id="taskList">

                        </div>

                 </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        function status_change(){
            var csrf=$('Input#csrf_token').val();
             $.ajax(
                    {

                        headers: {"X-CSRF-Token": csrf},
                        url:'task/'+$('#status').val(),
                        type:'post',
                         success:function(response){
                            $('#taskList').empty();
                            $('#taskList').append(response);


                         }

                    }
            )
        }

    </script>


@endsection
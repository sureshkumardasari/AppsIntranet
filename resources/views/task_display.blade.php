@extends('app')


@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a class="btn btn-success pull-right" name="new user" href="{{ url('addtask') }}">Create A New Task</a>
                    <div class="panel-heading">Task List

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
                        <form class="form-horizontal" role="form" method="get" action="{{ url('task/{id}/edit') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <table border="1" width="100%" id="dept_tbl" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    {{-- <th>
                                         Department Id
                                     </th>--}}
                                    <th>
                                        Task
                                    </th>
                                    <th>
                                        Description
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!$tasks->isEmpty())
                                    @foreach($tasks as $task)
                                        <tr>


                                            {{--<td> {{$dept->id}}</td>--}}
                                            <td> {{$task->task_title}} </td>
                                            <td> {{$task->task_description}}</td>
                                            <td><a href="{{ url('task/'.$task->id.'/edit') }}" >Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                <a href="{{ url('task/'.$task->id) }}" onclick="return confirm('Are you sure you want delete this user ?');">Delete</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No Records Found !</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </form>

                    </div>
                    <div>
                        @if(Session::has('message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! Session('message') !!}</em></div>
                        @endif
                    </div>
                    <div>
                        @if(Session::has('alert-class'))
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span><em> {!! Session('alert-class') !!}</em></div>
                        @endif
                    </div>

                </div>
                <a href="{{ URL::to('downloadExcelfortask/csv') }}"><button class="btn btn-info">Download CSV</button></a>
            </div>
        </div>
    </div>
@endsection
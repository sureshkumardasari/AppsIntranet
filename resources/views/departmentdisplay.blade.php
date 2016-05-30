@extends('app')


@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a class="btn btn-success pull-right" name="new user" href="{{ url('department_create') }}">Create New Dept</a>
                    <div class="panel-heading">Department List

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
                            <form class="form-horizontal" role="form" method="get" action="{{ url('department/{id}/edit') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table border="1" width="100%" id="dept_tbl" class="table table-bordered table-hover table-striped">
                                        <thead>
                                        <tr>
                                           {{-- <th>
                                                Department Id
                                            </th>--}}
                                            <th>
                                                Department Name
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
                                        @if(!$department->isEmpty())
                                            @foreach($department as $dept)
                                                <tr>


                                                    {{--<td> {{$dept->id}}</td>--}}
                                                    <td style="word-break: break-all ; max-width: 100px"> {{$dept->name}} </td>
                                                    <td style="word-break: break-all ; max-width: 100px" >  {{$dept->description}}</td>
                                                    <td style="word-break: break-all ; max-width: 100px"><a href="{{ url('department/'.$dept->id.'/edit') }}" >Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                        <a href="{{ url('department/'.$dept->id) }}" onclick="return confirm('Are you sure you want delete this Department ?');">Delete</a>
                                                    </td>

                                                </tr>
                                            @endforeach
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
                @if(!$department->isEmpty())
                <a href="{{ URL::to('downloadExcelfordepartment/csv') }}"><button class="btn btn-info">Download CSV</button></a>
                @endif
            </div>
        </div>
    </div>
@endsection
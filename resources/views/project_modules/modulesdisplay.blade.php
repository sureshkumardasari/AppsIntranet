@extends('app')


@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a class="btn btn-success pull-right" name="new user" href="{{ url('modulecreation') }}">Create A New Module</a>
                    <div class="panel-heading">Module List

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
                        <form class="form-horizontal" role="form" method="get" action="{{ url('module/{id}/edit') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <table border="1" width="100%" id="dept_tbl" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    {{-- <th>
                                         Department Id
                                     </th>--}}
                                    <th>
                                        Module Name
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
                                @if(!$module->isEmpty())
                                    @foreach($module as $mod)
                                        <tr>


                                            {{--<td> {{$dept->id}}</td>--}}
                                            <td> {{$mod->name}} </td>
                                            <td> {{$mod->description}}</td>
                                            <td><a href="{{ url('module/'.$mod->id.'/edit') }}" >Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                <a href="{{ url('module/'.$mod->id) }}" onclick="return confirm('Are you sure you want delete this user ?');">Delete</a>
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

                </div>
            </div>
        </div>
    </div>
@endsection
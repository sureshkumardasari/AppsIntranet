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
                                            <td style="word-break: break-all ; max-width: 100px"> {{$mod->name}} </td>
                                            <td style="word-break: break-all ; max-width: 100px"> {{$mod->description}}</td>
                                            <td style="word-break: break-all ; max-width: 100px"><a href="{{ url('module/'.$mod->id.'/edit') }}" >Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                <a class="confirm" href="javascript:;" data-ref="{{ url('module/'.$mod->id) }}" >Delete</a>
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
                @if(!$module->isEmpty())
                <a href="{{ URL::to('downloadExcelforprojectmodule/csv') }}"><button class="btn btn-info">Download CSV</button></a>
                @endif
            </div>

        </div>
    </div>
    <script type="text/javascript" src="{{ asset('/js/confirm.js')}}"></script>
@endsection
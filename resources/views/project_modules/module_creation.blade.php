@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Adding Module</div>
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
                        <form class="form-horizontal" role="form" method="post" action="{{url('addmodule')}}">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Project:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <select name="project_id" class="form-control" >
                                        <option value="" selected disabled hidden>--Select Project--</option>
                                        @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Module Title:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <input class="form-control" name="name" type="text" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Module Description:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class=" col-md-6">
                                    <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                       Submit
                                    </button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <a class="btn btn-default" href="{{  url('module') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                        @if(Session::has('success'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
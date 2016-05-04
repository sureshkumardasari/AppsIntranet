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

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Project Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{$projects->name }}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Project Description</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description" value="">{{ $projects->description }}</textarea>
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
@endsection

@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">adding modules</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="{{url('addmodule')}}">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">project:</label>
                                <div class="col-md-6">
                                    <select name="project_id" class="form-control" >
                                        <option value="" selected disabled hidden>please select</option>
                                        @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">module title:</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="name" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">module description:</label>
                                <div class=" col-md-6">
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-4">
                                    <button type="submit" name="submit" class=" form-control btn btn-primary">submit</button>
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
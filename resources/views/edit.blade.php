@extends('app')
@section('content')
<html>
<body>
<div class="container">
<table border="1" id="myTable" width="0" cellspacing="0" align="center">
    <form action="{{ url('update/'.$projects->id) }}" method="post">
        {{--{!! Form::DB($departments, array('route' => array('crud.departments.update', $departments->id), 'method' => 'PUT')) !!}--}}

        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" class="form-control" name="roles" value="1">
        <div class="form-group">
            <label>Name:</label>
            <input class="form-control" placeholder="Enter Name" name="name" value="{{ $projects->name }}" >
            <span class="text-danger">{{ $errors->first('name') }}</span>
        </div>

        <div class="form-group">
            <label>description:</label>
            <input class="form-control" placeholder="Enter description" name="description"  value="{{ $projects->description }}">
            <span class="text-danger">{{ $errors->first('description') }}</span>
        </div>

        <button type="submit" class="btn btn-default">Update</button>
        <button type="reset" class="btn btn-default">Reset</button>
        <a class="btn btn-default" href="{{  url('/project_view') }}">Cancel</a>

    </form>
</table>
</div>
</body>
</html>
@endsection
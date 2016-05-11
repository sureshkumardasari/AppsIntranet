@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Editing module</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="{{url('module',$module->id)}}">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Module Title:</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="name" type="text" value="{{ $module-> name }}" readonly>
                                    <span class="text-danger">{{ $errors->first('name') }}</span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Module Description:<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class=" col-md-6">
                                    <textarea class="form-control" name="description" value="">{{ $module-> description }}</textarea>
                                    <span class="text-danger">{{ $errors->first('description') }}</span>

                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <button type="reset" class="btn btn-default">Reset</button>
                                <a class="btn btn-default" href="{{  url('module') }}">Cancel</a>
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
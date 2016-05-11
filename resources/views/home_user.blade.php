@extends('app')

@section('content')
    <style>
        .fstElement { font-size: 0.8em; }
        .fstToggleBtn { min-width: 16.5em; }

        .submitBtn { display: none; }

        .fstMultipleMode { display: block; }
        .fstMultipleMode .fstControls { width: 100%; }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">User Profile</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/profileupdate/'.$users->id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">User Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username" value="{{  $users->username}}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">First Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name" value="{{ $users->first_name }}">
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Last Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name" value="{{  $users->last_name }}">
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ $users->email }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" value="{{ $users->password }}" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" value="{{ $users->password }}" name="password_confirmation">
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Edit
                                    </button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <a class="btn btn-default" href="{{  url('/') }}">Cancel</a>
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

    <script>
        $(".dobpicker").datepicker({ dateFormat: 'yy-mm-dd' });
        $(".jodpicker").datepicker({ dateFormat: 'yy-mm-dd' });

    </script>



@endsection

@extends('user_app')

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
                    <div class="panel-heading">USER PROFILE</div>
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
                            <?php
                            $user=Auth::user()->username;
                            $rows=\App\User::where('username',$user)->get();
                            foreach($rows as $row){
                            ?>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('user_profile') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="col-md-4 control-label">User Name</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="username" value="<?php echo $row['username'];?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">First Name</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="first_name" value="<?php echo $row['first_name'];?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Last Name</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="last_name" value="<?php echo $row['last_name'];?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="email" value="<?php echo $row['email'];?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password"  value="<?php echo $row['password'];?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            EDIT
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

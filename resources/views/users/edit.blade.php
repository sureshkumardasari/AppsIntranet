@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit </div>

                    <div class="panel-body">

                    </div>
    <div class="row">
        <div class="col-lg-12">

             <form action="{{url('users/update',$users->id)}}" method="post">
            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" class="form-control" name="roles" value="1">
            <div class="form-group">
                <label>User Name:</label>
                <input class="form-control" placeholder="Enter Name" name="username" value="{{ $users->username }}" >
                <span class="text-danger">{{ $errors->first('username') }}</span>
            </div>
                 <div class="form-group">
                     <label >First Name</label>
                     <input type="text" class="form-control" name="first_name" value="{{ $users->first_name }}">

                 </div>

                 <div class="form-group">
                     <label>Last Name</label>

                         <input type="text" class="form-control" name="last_name" value="{{ $users->last_name }}">

                 </div>
            <div class="form-group">
                <label>Email:</label>
                <input class="form-control" placeholder="Enter Email" name="email"  value="{{ $users->email }}">
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input class="form-control" placeholder="Enter Password" name="password" type="password" >
                <span class="help-block"> If you dont want to change the password leave it blank </span>
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>

            <div class="form-group">
                <label>Confirm Password:</label>
                <input class="form-control" placeholder="Retype Password" name="password_confirmation" type="password">
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
            </div>

            <button type="submit" class="btn btn-default">Update</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <a class="btn btn-default" href="{{  url('/users') }}">Cancel</a>

            </form>
        </div>
     </div>
    </div>
</div>
    </div>
    </div>
@endsection
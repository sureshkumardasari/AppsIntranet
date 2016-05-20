@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading"> Client Register</div>
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

          <form class="form-horizontal" role="form" method="POST" action="{{ url('/client') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
              <label class="col-md-4 control-label">Client Name<span style="color: red" >&nbsp; <b>*</b></span></label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="clientname" value="{{ old('clientname') }}">
              </div>
            </div>

           

            <div class="form-group">
              <label class="col-md-4 control-label">E-Mail Address<span style="color: red" >&nbsp; <b>*</b></span></label>
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
              </div>
            </div>

            <div class="form-group">
              <label  class="col-md-4 control-label">Phone1<span style="color: red" >&nbsp; <b>*</b></span></label>
              <div class="col-md-6">
                <input  type="text" class="form-control" id="number1" name="phone1" maxlength="10">
              </div>
            </div>
             <div class="form-group">
              <label  class="col-md-4 control-label">Phone2<span style="color: red" >&nbsp; <b>*</b></span></label>
              <div class="col-md-6">
                <input  type="text" class="form-control" id="number2" name="phone2" maxlength="10">
              </div>
            </div>
             <div class="form-group">
              <label class="col-md-4 control-label">Fax</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="fax">
              </div>
            </div>
             <div class="form-group">
              <label class="col-md-4 control-label">Skype Id</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="skypeid">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Address</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="address">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Submit
                </button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a class="btn btn-default" href="{{  url('/clientview') }}">Cancel</a>
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

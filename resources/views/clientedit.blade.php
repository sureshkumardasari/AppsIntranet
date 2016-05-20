@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Client Profile Edit</div>
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

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('update_client',$client->id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Client Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="clientname" value="{{  $client->clientname}}" >
                                </div>
                            </div>
                          <div class="form-group">
                                <label class="col-md-4 control-label">E-Mail Address<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ $client->email }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Phone1<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone1" value="{{ $client->phone1 }}" maxlength="10">
                                </div>
                            </div>

                          <div class="form-group">
                                <label class="col-md-4 control-label">Phone2<span style="color: red" >&nbsp; <b>*</b></span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone2" value="{{ $client->phone2 }}" maxlength="10">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-4 control-label">Fax</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="fax" value="{{ $client->fax }}">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-4 control-label">Skype Id</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="skypeid" value="{{ $client->skypeid }}">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-4 control-label">Address</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" value="{{ $client->address }}">
                                </div>
                            </div>

    
                            
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <a class="btn btn-default" href="{{  url('/clientview') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
 @endsection

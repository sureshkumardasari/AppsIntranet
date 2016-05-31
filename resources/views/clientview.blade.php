@extends('app')
@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a class="btn btn-success pull-right" name="new user" href="{{ url('/clientcreate') }}">Create New Client </a>
                    <div class="panel-heading">Clients List

                    </div>
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
                        <form class="form-horizontal" role="form" method="get" action="{{ url('clientedit/{id}/edit') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <table class="table table-bordered table-hover table-striped" id="clientview">
                                <thead>
                                <tr>
                                    <th>UserName</th>
                                    <th>Email</th>
                                    <th>Phone1</th>
                                    <th>Fax</th>
                                    <th>Skype Id</th>                                   
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($client)
                                    <?php $i=0;$j=0;?>
                                    @foreach($client as $clients)
                                        <tr>
                                            <td>{{ $clients->clientname }}</td>
                                            <td>{{ $clients->email }}</td>
                                              <td>{{ $clients->phone1 }}</td>
                                               <td>{{ $clients->fax }}</td>
                                                <td>{{ $clients->skypeid}}</td>
                                        
                                            <td><a href="{{ url('client/'.$clients->id.'/edit') }}" >Edit</a>
                                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                                <a class="confirm"  href="javascript:;" data-ref="{{ url('/deleted/'.$clients->id) }}" >Delete</a>
                                            
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No Records Found !</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                        </form>

                    </div>
                     <div>

                        @if(Session::has('flash_message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! Session('flash_message') !!}</em></div>
                        @endif
                    </div>
                    <div>

                        @if(Session::has('flash_message_failed'))
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span><em> {!! Session('flash_message_failed') !!}</em></div>
                        @endif
                    </div>


                </div>
                <!-- <div> <a href="{{ URL::to('downloadExcelforusers/csv') }}"><button class="btn btn-info">Download CSV</button></a></div> -->
            </div>
        </div>
    </div>
  <script type="text/javascript" src="{{ asset('/js/confirm.js')}}"></script> 
   
@endsection
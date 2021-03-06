
@extends('app')


@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a class="btn btn-success pull-right" name="new user" href="{{ url('project') }}">Create New Project</a>
                    <div class="panel-heading">Project List

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
            <table id="users" table border="1" width="100%" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>

                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>



                </tr>
                </thead>
                <tbody>
                <?php
                if($projects)
                {
                    $i=1;
                    foreach($projects as $row)
                    {

                        ?>
                        <tr>

                            <td style="word-break: break-all ; max-width: 100px"><?php echo $row->name;?></td>
                            <td style="word-break: break-all ; max-width: 100px"><?php echo $row->description; ?>
                            <td style="word-break: break-all ; max-width: 100px"><a href="{{ url('edit/'.$row->id) }}" >Edit</a>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                 <a class="confirm"  href="javascript:;" data-ref="{{ url('delete/'.$row->id) }}" >Delete</a></td>


                        </tr>

                        <?php

                    }     }?>
                </tbody>
            </table>
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
                @if(!$projects->isEmpty())
                <a href="{{ URL::to('downloadExcelforproject/csv') }}"><button class="btn btn-info">Download CSV</button></a>
                @endif
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('/js/confirm.js')}}"></script>
@endsection

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

                            <td><?php echo $row->name;?></td>
                            <td><?php echo $row->description; ?>
                            <td><a href="{{ url('edit/'.$row->id) }}" >Edit</a>
                                &nbsp;&nbsp;|&nbsp;&nbsp; <a href="{{ url('delete/'.$row->id) }}" onclick="return confirm('Are you sure you want delete this user ?');">Delete</a></td>


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
            </div>
        </div>
    </div>
@endsection
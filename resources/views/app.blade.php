<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TRACKING SYSTEM</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    {{--<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->


	<link href="{{ asset('/js/fastselect.min.css') }}" rel="stylesheet">
	<script src="{{ asset('/js/fastselect.standalone.js') }}"></script>
	<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}" type="text/css">

	<script type="text/javascript" src="{{asset('js/bootstrap-multiselect.js')}}"></script>


    <style>

        .fstElement { font-size: 1.2em; }
        .fstToggleBtn { min-width: 16.5em; }

        .submitBtn { display: none; }

        .fstMultipleMode { display: block; }
        .fstMultipleMode .fstControls { width: 100%; }
        /* Dropdown Button */
        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

		/* The container <div> - needed to position the dropdown content */
		.dropdown {
			position: relative;
			display: inline-block;
		}

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {background-color: #f1f1f1}

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
            margin-top:40px;
        }

        /* Change the background color of the dropdown button when the dropdown content is shown */
        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
        tr.group,
        tr.group:hover {
            background-color: #ddd !important;
        }

    </style>


</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <a class="navbar-brand" href="#">
                <img class="logo-img" src="{{ asset('/images/logo.png') }}">
            </a>
            <?php
            if(Entrust::hasRole('Admin')) {

            ?>
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/department') }}">Department</a></li>
                <li><a href="{{ url('/project_view') }}">Project</a></li>
                <li><a href="{{ url('/users') }}">Users</a></li>
                <li><a href="{{ url('/module') }}">Module</a></li>
                <li><a href="{{ url('/task') }}">Task</a></li>
                <li><a href="{{ url('/clientview') }}">Client</a></li>
                <li><a href="{{ url('/UsersTimesheet') }}">UserTimesheet</a></li>
            </ul>
            <div class="dropdown" style="z-index: 1">
                <ul class="nav navbar-nav"><li><a href="#">Timesheet</a></li>
                    <div class="dropdown-content">
                        <a href="{{ url('/timesheet') }}">Add</a>
                        <a href="{{ url('/timesheet_display') }}">Display</a>
                    </div>
                </ul>
            </div>

            <?php }?>
            <?php
            if(Entrust::hasRole('User')) {
            ?>
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/modulecreation') }}">Module</a></li>
                <li><a href="{{ url('/task') }}">Task</a></li>
            </ul>
            <div class="dropdown"  style="z-index: 1">
                <ul class="nav navbar-nav"><li><a href="#">Timesheet</a></li>
                    <div class="dropdown-content">
                        <a href="{{ url('/timesheet') }}">Add</a>
                        <a href="{{ url('/timesheet_display') }}">Display</a>
                    </div>
                </ul>
            </div>
            </ul>
            <?php }?>
            <?php
            if(Entrust::hasRole('Project Lead')) {
            ?>
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/department') }}">Department</a></li>
                <li><a href="{{ url('/project_view') }}">Project</a></li>
                <li><a href="{{ url('/users') }}">Users</a></li>
                <li><a href="{{ url('/module') }}">Module</a></li>
                <li><a href="{{ url('/task') }}">Task</a></li>
            </ul>
            <div class="dropdown"  style="z-index: 1">
                <ul class="nav navbar-nav"><li><a href="#">Timesheet</a></li>
                    <div class="dropdown-content">
                        <a href="{{ url('/timesheet') }}">Add</a>
                        <a href="{{ url('/timesheet_display') }}">Display</a>
                    </div>
                </ul>
            </div>
            <?php }?>
            <?php
            if(Entrust::hasRole('Project Manager')) {
            ?>
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/department') }}">Department</a></li>
                <li><a href="{{ url('/project_view') }}">Project</a></li>
                <li><a href="{{ url('/users') }}">Users</a></li>
                <li><a href="{{ url('/module') }}">Module</a></li>
                <li><a href="{{ url('/task') }}">Task</a></li>

            </ul>
            <div class="dropdown"  style="z-index: 1">
                <ul class="nav navbar-nav"><li><a href="#">Timesheet</a></li>
                    <div class="dropdown-content">
                        <a href="{{ url('/timesheet') }}">Add</a>
                        <a href="{{ url('/timesheet_display') }}">Display</a>
                    </div>
                </ul>
            </div>
            <?php }?>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/login') }}">Login</a></li>
                    <!-- <li><a href="{{ url('/homes') }}">Login</a></li> -->
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/profile') }}">Profile</a></li>
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@if(isset($permissionerror))
<div class="row">
        <div class="span12" style="margin-top:200px;margin-left:500px;">
            <h1 style="color:red">{{$permissionerror}}</h1>
        </div>
    </div>
@endif


@yield('content')

        <!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#dept_tbl').DataTable();
        $('#users').DataTable();
        $('#userview').DataTable();
	   $('#timesheet').DataTable({
          // var table = $('#example').DataTable({
//               columns: [
//                   {
//                      name: 'second',
//                       title: 'Project Name',
//                   },
//                   {
//
//                       title: 'Module Name',
//                   },
//                   {
//                       title: 'Task Title',
//                   },
//                   {
//                       title: 'Task Created At',
//                   },
//                   {
//                       title: 'Task Updated At',
//                   },
//                   {
//                       title: 'Hours Spent',
//                   },
//                   {
//                       title: 'Status',
//                   },
//                   {
//                       title: 'Action',
//                   },
//               ],
               //data: data,
               rowsGroup: [// Always the array (!) of the column-selectors in specified order to which rows groupping is applied
                   // (column-selector could be any of specified in https://datatables.net/reference/type/column-selector)
                   //'second:name',
                   0,
                   1,2


               ],
               pageLength: '20',
           });
   // } );

//        "columnDefs": [
//               { "visible": false, "targets": 0 }
//           ],
//           "order": [[ 0, 'asc' ]],
//           "displayLength": 25,
//           "drawCallback": function ( settings ) {
//               var api = this.api();
//               var rows = api.rows( {page:'current'} ).nodes();
//               var last=null;
//
//               api.column(0, {page:'current'} ).data().each( function ( group, i ) {
//                   if ( last !== group ) {
//                       $(rows).eq( i ).before(
//                               '<tr class="group"><td colspan="7"  style="color:red;font-weight: bold;">'+group+'</td></tr>'
//                       );
//
//                       last = group;
//                   }
//               } );
//           }
//       });
//        $('#timesheet tbody').on( 'click', 'tr.group', function () {
//            var currentOrder = table.order()[0];
//            if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
//                table.order( [ 2, 'desc' ] ).draw();
//            }
//            else {
//                table.order( [ 2, 'asc' ] ).draw();
//            }
//        } );
//
        $('#clientview').DataTable();
        $('#task_tbl').DataTable();

    });
</script>
</body>
</html>

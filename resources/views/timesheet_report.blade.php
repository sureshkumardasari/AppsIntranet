<!DOCTYPE html>
<html>
<head>
    <style>

    </style>
</head>
<body>
<table>
     <thead>
    <tr>
        <th  colspan="10" align="center" style="font-family: Arial;color: #0066cc;"><strong>AppsTek Weekly Timesheet</strong><img width="20%" height="50%" class="logo-img" src="../public/images/logo.png"></th>
    </tr>
    <tr>
        <th align="left"  colspan="10" style="background-color: #33CCCC;font-family: Arial;font-style: italic;">Email Id: timesheet@appstekcorp.com</th>
    </tr>
    <tr align="left">
    <tr>
        <th align="left" colspan="2" style="background-color: #333333;font-family: Arial;color:#fff;">Employee/Consultant Information</th>
        <th colspan="6"></th>
        <th align="left" colspan="2" style="background-color: #333333;font-family: Arial;color:#fff;">Client Information</th>
    </tr>
    <tr>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;">First Name:</th>
        <th align="left" colspan="2" style="font-family: Arial;color:#000;">{{$user_data->first_name}}</th>
        <th colspan="5"></th>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;">Name:</th>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;">{{$client_name->clientname}}</th>
    </tr>
    <tr>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;">Last Name:</th>
        <th align="left"  colspan="2" style="font-family: Arial;color:#000;">{{$user_data->last_name}}</th>
        <th colspan="5"></th>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;">EMail Id:</th>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;">{{$client_name->email}}</th>
    </tr>
    <tr>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;">Email Id:</th>
        <th align="left"  colspan="2" style="font-family: Arial;color:#000;;">{{$user_data->email}}</th>
        <th colspan="5"></th>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;">Address:</th>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;">{{$client_name->address}}</th>
    </tr>
    <tr>
        <th align="right" style="background-color: #c0c0c0;font-family: Arial;color:#4D3399;"></th>
        <th align="left" colspan="2"  style="font-family: Arial;color:#000;"></th>
        <th colspan="5"></th>
    </tr>
    </tr>

    <tr class="caption" style="background-color: #33CCCC;font-family: Arial;font-style: italic;color:#fff;">
        <th>Project</th>
        <th>Task</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
        <th>Sunday</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @if($report_data[0]!=null)
        @foreach($report_data as $timesheets)
            <tr>
                {{--jhkjhk--}}
                <td width="20px">{{$timesheets['project_name']}}</td>
                <td width="20px">{{$timesheets['task_title']}}</td>
                <td width="20px">{{$timesheets['hours_monday']}}</td>
                <td width="20px">{{$timesheets['hours_tuesday']}}</td>
                <td width="20px">{{$timesheets['hours_wednesday']}}</td>
                <td width="20px">{{$timesheets['hours_thursday']}}</td>
                <td width="20px">{{$timesheets['hours_friday']}}</td>
                <td width="20px">{{$timesheets['hours_saturday']}}</td>
                <td width="20px">{{$timesheets['hours_sunday']}}</td>
                <td width="20px" style="background-color: #969696;">{{$timesheets['total_hours_spent']}} : {{$timesheets['total_minutes_spent']}}</td>
            </tr>
        @endforeach
        <tr>

            <td style="background-color: #969696;"></td>
            <td style="background-color: #969696;"></td>
            <td style="background-color: #969696;"></td>
            <td style="background-color: #969696;"></td>
            <td style="background-color: #969696;"></td>
            <td style="background-color: #969696;"></td>
            <td style="background-color: #969696;"></td>
            <td style="background-color: #969696;"></td>
            <td style="background-color: #969696;"></td>
            <td style="background-color: #969696;">{{$totalhoursspent}}:{{$totalminutesspent}}</td>
        </tr>

    @else
        <tr>
            <td colspan="5">NO DATA TO DISPLAY</td>
        </tr>
    @endif
    </tbody>
</table>
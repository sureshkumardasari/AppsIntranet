<table>
    <thead>
    <tr>
        <th colspan="7" align="center" style="font-family: Arial;color: blue;">AppsTek Weekly Timesheet</th>
     </tr>
    <tr class="caption">
        {{--<th rowspan="2"><img class="logo-img" src="../public/images/logo.png"></th>--}}
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
    <tr class="caption">
        {{--<th rowspan="2"><img class="logo-img" src="../public/images/logo.png"></th>--}}
        {{--<th></th>--}}
        {{--<th></th>--}}
        {{--<th> {{ $user->created_at->format('Y-m-d') }}</th>--}}
        {{--<th>Tuesday</th>--}}
        {{--<th>Wednesday</th>--}}
        {{--<th>Thursday</th>--}}
        {{--<th>Friday</th>--}}
        {{--<th>Saturday</th>--}}
        {{--<th>Sunday</th>--}}
        {{--<th>Total</th>--}}
    </tr>
    {{--<tr class="caption">--}}
         {{--<th rowspan="2">Name</th>--}}
         {{--<th rowspan="2">Email id:</th>--}}
         {{--<th rowspan="2">Phone:</th>--}}
         {{--<th rowspan="2">Project Name</th>--}}
    {{--</tr>--}}
      </thead>
    <tbody>

        @foreach($timesheet as $timesheets)
        <tr>
        <td width="20px">{{$timesheets->project_name}}</td>
        <td width="20px">{{$timesheets->task_title}}</td>
        <td width="20px">{{$timesheets->hours}}</td>
        <td width="20px">{{$timesheets->task_title}}</td>
        <td width="20px">{{$timesheets->task_title}}</td>
        <td width="20px">{{$timesheets->task_title}}</td>
        <td width="20px">{{$timesheets->task_title}}</td>
        <td width="20px">{{$timesheets->task_title}}</td>
        <td width="20px">{{$timesheets->task_title}}</td>
        <td width="20px">{{$timesheets->task_title}}</td>
        </tr>
        @endforeach



    </tbody>
</table>
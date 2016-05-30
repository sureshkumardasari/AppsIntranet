

<table border="1" width="100%" id="dept_tbl" class="table table-bordered table-hover table-striped">
    <thead>
    <tr>
        <th>
            Task
        </th>
        <th>
            Description
        </th>
        <th>
            Action
        </th>
    </tr>
    </thead>
    <tbody>
    @if(!$user_data_task->isEmpty())
        @foreach($user_data_task as $a)
            <tr>
                <td> {{$a->task_title}} </td>
                <td> {{$a->task_description}}</td>
                <td>

                    <a href="{{ url('task/'.$a->id.'/edit') }}" >Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a class="confirm" href="javascript:;" data-ref="{{ url('task/'.$a->id).'/delete' }}" >Delete</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="{{ url('task/'.$a->id.'/viewlog') }}" >Viewlog</a>&nbsp;&nbsp;
                </td>
            </tr>
        @endforeach


    @endif
    </tbody>
    {{--<div>
        @if(Session::has('message'))
            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! Session('message') !!}</em></div>
        @endif
    </div>
    <div>
        @if(Session::has('alert-class'))
            <div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span><em> {!! Session('alert-class') !!}</em></div>
        @endif
    </div>--}}
</table>
<script>
    $(document).ready(function() {
    $('#dept_tbl').DataTable();

});
</script>
<script type="text/javascript" src="{{asset('/js/confirm.js')}}"></script>


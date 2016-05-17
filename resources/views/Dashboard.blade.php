

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
                    <a href="{{ url('task/'.$a->id) }}" onclick="return confirm('Are you sure you want delete this user ?');">Delete</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="{{ url('task/'.$a->id.'/edit') }}" >Viewlog</a>&nbsp;&nbsp;
                </td>
            </tr>
        @endforeach


    @endif
    </tbody>
</table>

<script>
    $(document).ready(function() {
    $('#dept_tbl').DataTable();

});
</script>

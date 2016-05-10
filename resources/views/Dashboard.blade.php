

<table border="1" width="100%" id="dept_tbl" class="table table-bordered table-hover table-striped">
    <thead>
    <tr>
        <th>
            Task
        </th>
        <th>
            Description
        </th>
    </tr>
    </thead>
    <tbody>
    @if(!$user_data_task->isEmpty())
        @foreach($user_data_task as $a)
            <tr>
                <td> {{$a->task_title}} </td>
                <td> {{$a->task_description}}</td>
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



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
                    <a class="js-open-modal" data-modal-id="popup"  >Viewlog</a>&nbsp;&nbsp;
                </td>
            </tr>
        @endforeach


    @endif
    </tbody>
</table>
<div id="popup" class="modal-box">  
<form class="form-horizontal" role="form" method="POST" action="{{ url('view'.$a->id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $a->id }}">
  <header>
    <a href="#" class="js-
    -close close">×</a>
    <h3><a href="http://www.jqueryscript.net/tags.php?/Modal/"></a> Title</h3>
  </header>
  <div class="modal-body">
    <p>Modal Body</p>
       <table>        
       <tbody>
    @if(!$user_data_task->isEmpty())
        @foreach($user_data_task as $a)
            <tr>
            <td>Task name</td>
                <td> {{$a->task_title}} </td>
            </tr>
            <tr>
                <td>Description</td>
                <td> {{$a->task_description}}</td>
            </tr>

        @endforeach
    @endif
    </tbody>
    </table> 
  </div>
  <footer>
    <a href="#" class="js-modal-close">Close</a>
  </footer>
</form>
</div>
<script>
    $(document).ready(function() {
    $('#dept_tbl').DataTable();

});
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">
$(function(){

var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

  $('a[data-modal-id]').click(function(e) {
    e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    //$(".js-modalbox").fadeIn(500);
    var modalBox = $(this).attr('data-modal-id');
    $('#'+modalBox).fadeIn($(this).data());
  });  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
  $(".modal-box, .modal-overlay").fadeOut(500, function() {
    $(".modal-overlay").remove();
  });
});
 
$(window).resize(function() {
  $(".modal-box").css({
    top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
    left: ($(window).width() - $(".modal-box").outerWidth()) / 2
  });
});
 
$(window).resize();
 
});
</script>
<style type="text/css">
    .modal-box {
  display: none;
  position: absolute;
  z-index: 1000;
  width: 98%;
  background: white;
  border-bottom: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
}

.modal-box header,
.modal-box .modal-header {
  padding: 1.25em 1.5em;
  border-bottom: 1px solid #ddd;
}

.modal-box header h3,
.modal-box header h4,
.modal-box .modal-header h3,
.modal-box .modal-header h4 { margin: 0; }

.modal-box .modal-body { padding: 2em 1.5em; }

.modal-box footer,
.modal-box .modal-footer {
  padding: 1em;
  border-top: 1px solid #ddd;
  background: rgba(0, 0, 0, 0.02);
  text-align: right;
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3) !important;
}

a.close {
  line-height: 1;
  font-size: 1.5em;
  position: absolute;
  top: 5%;
  right: 2%;
  text-decoration: none;
  color: #bbb;
}

a.close:hover {
  color: #222;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}

@media (min-width: 32em) {
  .modal-box { width: 70%; }
}
</style>

<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Tasks;
use App\User;
use App\Project;
use App\projectModules;
use Illuminate\Support\Facades\Input;
use App\TimeSheet;
use Validator;
use Redirect;
use Excel;
use Response;
use App\Department;
use App\ProjectUser;
use App\Client;

class TimesheetController extends Controller {

    //
    public function index(){
        //$a= Auth::user();
        // return $a;
//$tasks=Tasks::select('project_id','description','date')->where('User_id',1)->orderBy('date','desc')->get();

        //return $tasks;
        // return view('timesheet');
        /////////////////////

        $projects=Project::select('id','name')->get();
        return view('timesheet',compact('projects'));
    }
    public function add(){
        $data= Input::except('_token');
        $messages = [
             'project_id.required'=>'Please select a project',
            
            'task_id.required'=>'Please select a task',
            'comment.required'=>'Please give a comment',
            'status.required'=>'Please select status of the project',
            'hours.required'=>'Mention Time spent on project',
            'minutes.required'=>'Mention Time spent on project',
        ];
        $rules = [
            'project_id'=>'required',
            
            'task_id'=>'required',
            'comment'=>'required',
            'status'=>'required',
            'hours'=>'required',
            'minutes'=>'required',
        ];

       $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }

        TimeSheet::create($data);
        $status=$data['status'];
        $taskid=$data['task_id'];
        $tasks = Tasks::find($taskid);
        $tasks->status=$status;
        $tasks->save();
        return Redirect::back()->with('success','Timesheet Created Successfully');
    }

    public function display_timesheet($data=null){
        $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
            ->join('project_modules',"project_modules.id",'=','time_sheets.module_id')
            ->join('tasks','tasks.id','=','time_sheets.task_id');

        if($data==null){
        $department_list=Department::distinct('name')->get();
        if (\Request::isMethod('post'))
        {
            return $timesheet->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.task_id as task_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
                ->get();
        }
        else{
            $timesheet=$timesheet->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.task_id as task_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
                ->get();
            return view('timesheet_display',compact('timesheet','department_list'));}
        }
        else return $timesheet->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.task_id as task_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
           ->orderBy('projects.id')->orderBy('tasks.task_title')
            ->get();
    }

    public function filter($data=null){
if($data==null) {
    $data = Input::all();
}

        $department=$data['department'];
        if(isset($data['project'])){
            $project=$data['project'];
        }
        else $project=0;
        if(isset($data['module'])){
            $module=$data['module'];
        }
        else $module=0;
        if(isset($data['task'])){
            $task=$data['task'];
        }
        else $task=0;
        if(isset($data['user'])){
            $user=$data['user'];
    }
        else $user=0;
        if(isset($data['from_date'])){
            $from_date=$data['from_date'];
        }
        else $from_date=null;
        if(isset($data['to_date'])){
            $to_date=$data['to_date'];
        }
        else $to_date=null;
        $timesheet="";
        if($department){
            $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
                ->join('projects_depart','projects.id','=','projects_depart.project_id')
                ->join('departments','departments.id','=','projects_depart.depart_id')
                ->join('project_modules','project_modules.id','=','time_sheets.module_id')
                ->join('tasks','tasks.id','=','time_sheets.task_id')
                ->join('users','users.id','=','tasks.user_id')->where('departments.id',$department);
            if($project!=0 && $project!=null){
                $timesheet->where('projects.id',$project);
            }
            if($module!=0 &&$module!=null){
                $timesheet->where('tasks.module_id',$module);
            }
            if($task!=0 && $task!=null){
                $timesheet->where('tasks.id',$task);
            }
            if($user!=0 && $user!=null){
                $timesheet->where('users.id',$user);
            }
            if($from_date!=null) {

                if ($to_date != null) {
                    $timesheet->whereBetween('tasks.created_at',[$from_date, $to_date]);
                } else {

                    $timesheet->where('tasks.created_at','>=', $from_date);
                }
            }
            if(isset($data['from_method'])){
                $timesheet->orderBy('projects.id')->orderBy('tasks.task_title');
            }
            $timesheet=$timesheet->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.task_id as task_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')->get();
        }
        return $timesheet;
//        if($data['module']==0){
//            //return "ljhkh";
//            $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
//                ->join('project_modules',"project_modules.id",'=','time_sheets.module_id')
//                ->join('tasks','tasks.id','=','time_sheets.task_id')
//                ->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
//                ->where('projects.id',$project)
//                ->get();
//            return $timesheet;
//        }
//        elseif($module>0){
//            $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
//                ->join('project_modules',"project_modules.id",'=','time_sheets.module_id')
//                ->join('tasks','tasks.id','=','time_sheets.task_id')
//                ->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
//                ->where('projects.id',$project)
//                ->where('project_modules.id',$module)
//                ->get();
//            return $timesheet;
//        }


    }

    //used to edit the timesheet
    //argument is the id of the timesheeet which need to be edited..
    public function edit($timesheet_id){
        $data=Timesheet::find($timesheet_id);
        $project_id=$data->project_id;
        $module_id=$data->module_id;
        $task_id=$data->task_id;
        $project=Project::select('name')->where('id',$project_id)->first();
        $module=projectModules::select('name')->where('id',$module_id)->first();
        $task=Tasks::select('task_title')->where('id',$task_id)->first();
        return view('timesheet_edit',compact('data','project','module','task','task_id'));
    }

    //update  task timesheet
    public function update(){
        $data= Input::except('_token');
         $messages = [
            
            'comment.required'=>'Please give a comment',
            'status.required'=>'Please select status of the project',
            'hours.required'=>'Mention Time spent on project',
            'minutes.required'=>'Mention Time spent on project',
        ];
        $rules = [
            
            'comment'=>'required',
            'status'=>'required',
            'hours'=>'required',
            'minutes'=>'required',
        ];

       $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }
        TimeSheet::where('id',Input::get('timesheet_id'))
            ->update(['comment'=>Input::get('comment'),'status'=>Input::get('status'),'hours'=>Input::get('hours'),'minutes'=>Input::get('minutes')]);
        $status=$data['status'];
        $taskid=$data['taskid'];
        $tasks = Tasks::find($taskid);
        $tasks->status=$status;
        $tasks->save();
        return Redirect::route('timesheet_display');

    }
//
//public function downloadFullExcel($type)
//    {
//        $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
//            ->join('project_modules',"project_modules.id",'=','time_sheets.module_id')
//            ->join('tasks','tasks.id','=','time_sheets.task_id')
//            ->select('projects.name as project_name','project_modules.name as module_name','tasks.task_title','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
//            ->get();
//        return Excel::create('Report', function($excel) use ($timesheet) {
//            $excel->sheet('Report', function($sheet) use ($timesheet)
//            {
//                $sheet->loadView('timesheet_report', array('timesheet' => $timesheet));
////                $sheet->loadView('timesheet_report')->witharray('timesheet');
////                $sheet->fromArray($timesheet);
////                $sheet->cell('A1', function($cell) {
////
////                    $cell->setBackground('#000000');
////
////                });
//            });
//
//        })->download($type);
//    }
    public function downloadExcel($type){
        $data=Input::all();
        $data=($data['data']);
        $data=json_decode($data);
        $filter_data['from_method']="downloadExcel";
        $filter_data['department']=$data->department;
        $filter_data['project']=$data->project;
        $filter_data['module']=$data->module;
        $filter_data['task']=$data->task;
        $filter_data['user']=$data->user;
        $filter_data['from_date']=$data->from_date;
        $filter_data['to_date']=$data->to_date;
        if( $filter_data['user']){
        $user_data=User::where('id',$filter_data['user'])->first();
        }
        else {
            $user_data=['first_name'=>"",'last_name'=>"",'email'=>""];
        $user_data=json_decode(json_encode( $user_data));
        }

        if($filter_data['project']) {
            $client_data = Project::where('id', $filter_data['project'])->select('client_id')->first();
            $client_name = Client::where('id', $client_data->client_id)->first();
            if($client_name==null){
                $client_name=['clientname'=>"not mentioned",'email'=>"not mentioned",'address'=>"not mentioned"];
                $client_name=json_decode(json_encode( $client_name));
            }
           }
        else  {
            $client_name=['clientname'=>"",'email'=>"",'address'=>""];
        $client_name=json_decode(json_encode( $client_name));
        }

         if ($filter_data['department']==0){
            $timesheet=$this->display_timesheet("downloadFullExcel");
        }
    else{
        $timesheet=$this->filter($filter_data);
         }

$task="";

        $i=0;

        $report_data = Array();
        $a = Array();
        $totalhoursspent = 0;
        $totalminutesspent = 0;
        foreach ($timesheet as $time) {

             if($task == $time->task_title){

                if(date('D',strtotime($time->created_at))=="Mon")
                $a['hours_monday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Tue")
                    $a['hours_tuesday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Wed")
                    $a['hours_wednesday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Thu")
                    $a['hours_thursday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Fri")
                    $a['hours_friday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Sat")
                    $a['hours_saturday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Sun")
                    $a['hours_sunday']=$time->hours.":".$time->minutes;
                $a['total_hours_spent'] +=$time->hours;
                $a['total_minutes_spent'] +=$time->minutes;
		 $totalhoursspent += $time->hours;
                $totalminutesspent += $time->minutes;
                if($a['total_minutes_spent'] >=60 ){
                    $a['total_hours_spent'] +=intval(( $a['total_minutes_spent']/60 ));
                    $a['total_minutes_spent']=($a['total_minutes_spent']%60);
                }
            }
            else{
                if($i!=0){
                    array_push($report_data,$a);
                }
                $i++;
                $a=Array();
                $a['total_hours_spent']=0;
                $a['total_minutes_spent']=0;
                $a['hours_monday']=0;
                $a['hours_tuesday']=0;
                $a['hours_wednesday']=0;
                $a['hours_thursday']=0;
                $a['hours_friday']=0;
                $a['hours_saturday']=0;
                $a['hours_sunday']=0;
                $a['project_name']=$time->project_name;
                $a['task_title']=$time->task_title;
                if(date('D',strtotime($time->created_at))=="Mon")
                    $a['hours_monday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Tue")
                    $a['hours_tuesday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Wed")
                    $a['hours_wednesday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Thu")
                    $a['hours_thursday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Fri")
                    $a['hours_friday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Sat")
                    $a['hours_saturday']=$time->hours.":".$time->minutes;
                if(date('D',strtotime($time->created_at))=="Sun")
                    $a['hours_sunday']=$time->hours.":".$time->minutes;
                $a['total_hours_spent']=$time->hours;
                $a['total_minutes_spent']=$time->minutes;
		$totalhoursspent += $time->hours;
                $totalminutesspent += $time->minutes;
			
            }
            $task = $time->task_title;
        }
        array_push($report_data, $a);
        if ($totalminutesspent >= 60){

        $totalhoursspent += intval($totalminutesspent/60);
            $totalminutesspent = ($totalminutesspent % 60);
            }
          return Excel::create('Report', function($excel) use ($report_data,$totalhoursspent,$totalminutesspent,$user_data,$client_name) {
            $excel->sheet('Report', function($sheet) use ($report_data,$totalhoursspent,$totalminutesspent,$user_data,$client_name)
            {
                $sheet->loadView('timesheet_report', array('report_data' => $report_data,'totalhoursspent'=>$totalhoursspent,'totalminutesspent'=>$totalminutesspent,'user_data'=>$user_data,'client_name'=>$client_name));
                $sheet->setStyle(array(
                    'font' => array(
                         'bold'      =>  true
                    )
                ));
            });
        })->download($type);
    }
    public function usertimesheet()
    {
        $users=User::get();
        return view('usertimesheet',compact('users'));
    }
    public function projectlist($id)
    {
        $project=ProjectUser::where('user_id','=',$id)
            ->select('project_id')
            ->get();
        $id=array();
        foreach($project as $proj)
            array_push($id,$proj->project_id);

        $projects=Project::wherein('id',$id)
            ->select('name','id')->get();
        return($projects);
    }



}
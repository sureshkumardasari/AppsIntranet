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


        $validator=Validator::make($data,[
            'project_id'=>'required','module_id'=>'required','task_id'=>'required','comment'=>'required','status'=>'required','hours'=>'required','minutes'=>'required']);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }

        TimeSheet::create($data);
        return Redirect::back()->with('success','Timesheet Created Successfully');
    }

    public function display_timesheet(){
        $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
            ->join('project_modules',"project_modules.id",'=','time_sheets.module_id')
            ->join('tasks','tasks.id','=','time_sheets.task_id')
            ->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
            ->get();
        //$project_list=Project::distinct('name')->get();
        // return $project_list;
        $department_list=Department::distinct('name')->get();
        if (\Request::isMethod('post'))
        {
            return $timesheet;
        }
        else
            return view('timesheet_display',compact('timesheet','department_list'));
    }

    public function filter($data=null){
if($data==null) {
    $data = Input::all();
}


        //dd($data);
        $department=$data['department'];
        if(isset($data['project'])){
        $project=$data['project'];}
        else $project=0;
        if(isset($data['module']))
        $module=$data['module'];
        else $module=0;
        if(isset($data['task']))
        $task=$data['task'];
        else $task=0;
        if(isset($data['user']))
        $user=$data['user'];
        else $user=0;
        if(isset($data['from_date']))
        $from_date=$data['from_date'];
        else $from_date=null;
        if(isset($data['to_date']))
        $to_date=$data['to_date'];
        else $to_date=null;
        // return $data['project'];
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
            $timesheet=$timesheet->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')->get();


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

        //return($id);
        $data=Timesheet::find($timesheet_id);
        //dd($data);
        $project_id=$data->project_id;

        $module_id=$data->module_id;

        $task_id=$data->task_id;
        //dd($taskid);
        $project=Project::select('name')->where('id',$project_id)->first();
        //dd($project);
        $module=projectModules::select('name')->where('id',$module_id)->first();
        $task=Tasks::select('task_title')->where('id',$task_id)->first();
        return view('timesheet_edit',compact('data','project','module','task'));
    }

    //update  task timesheet
    public function update(){
        $data= Input::except('_token');


        $validator=Validator::make($data,[
            'comment'=>'required','status'=>'required','hours'=>'required','minutes'=>'required']);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }
        TimeSheet::where('id',Input::get('timesheet_id'))
            ->update(['comment'=>Input::get('comment'),'status'=>Input::get('status'),'hours'=>Input::get('hours'),'minutes'=>Input::get('minutes')]);
        return Redirect::route('timesheet_display');

}
//
//public function downloadExcel($type)
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
    public function downloadExcel($type,$data=null){
        dd($data['department']);
        //$data//=Input::all();
//        $response->header('Content-Type','application/excell');
        $timesheet=$this->filter($data);
         return Excel::create('Report', function($excel) use ($timesheet) {
           $excel->sheet('Report', function($sheet) use ($timesheet)
            {
                $sheet->loadView('timesheet_report', array('timesheet' => $timesheet));
//                $sheet->loadView('timesheet_report')->witharray('timesheet');
//                $sheet->fromArray($timesheet);
//                $sheet->cell('A1', function($cell) {
//
//                    $cell->setBackground('#000000');
//
//                });
            });

        })->download($type) ->header('Content-Type', 'application/csv')->header('Content-Disposition','attachment');
     }

}

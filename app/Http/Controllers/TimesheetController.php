<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Tasks;
use App\User;
use Excel;
use App\Project;
use Illuminate\Support\Facades\Input;
use App\TimeSheet;
use Validator;
use Redirect;

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
        $validator=Validator::make($data,['project_id'=>'required','module_id'=>'required','task_id'=>'required','comment'=>'required','status'=>'required','hours'=>'required','minutes'=>'required']);
if($validator->fails()){
//    return "failed";
    return Redirect::back()->with('error','Please Enter Fields');
}
        TimeSheet::create($data);
        return Redirect::back()->with('success','Timesheet Created Successfully');
    }

    public function display_timesheet(){
        $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
        ->join('project_modules',"project_modules.id",'=','time_sheets.module_id')
            ->join('tasks','tasks.id','=','time_sheets.task_id')
            ->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.created_at','time_sheets.updated_at')
        ->get();
        $project_list=Project::distinct('name')->get();
       // return $project_list;
    return view('timesheet_display',compact('timesheet','project_list'));
    }

    public function filter(){
        $data=Input::all();
        $project=$data['project'];
        $module=$data['module'];
       // return $data['project'];
        if($data['module']==0){
            //return "ljhkh";
            $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
                ->join('project_modules',"project_modules.id",'=','time_sheets.module_id')
                ->join('tasks','tasks.id','=','time_sheets.task_id')
                ->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.created_at','time_sheets.updated_at')
                ->where('projects.id',$project)
                ->get();
            return $timesheet;
        }
        elseif($module>0){
            $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
                ->join('project_modules',"project_modules.id",'=','time_sheets.module_id')
                ->join('tasks','tasks.id','=','time_sheets.task_id')
                ->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.created_at','time_sheets.updated_at')
                ->where('projects.id',$project)
                ->where('project_modules.id',$module)
                ->get();
            return $timesheet;
        }


    }
    public function downloadExcel($type)
    {
        $data = Timesheet::get()->toArray();
        return Excel::create('userlist', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }
}

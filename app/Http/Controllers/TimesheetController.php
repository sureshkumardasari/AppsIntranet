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
            ->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
            ->get();
        $project_list=Project::distinct('name')->get();
        // return $project_list;
        if (\Request::isMethod('post'))
        {
            return $timesheet;
        }
        else
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
                ->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
                ->where('projects.id',$project)
                ->get();
            return $timesheet;
        }
        elseif($module>0){
            $timesheet=TimeSheet::join('projects','projects.id','=','time_sheets.project_id')
                ->join('project_modules',"project_modules.id",'=','time_sheets.module_id')
                ->join('tasks','tasks.id','=','time_sheets.task_id')
                ->select('projects.id as project_id','projects.name as project_name','project_modules.id as module_id','project_modules.name as module_name','tasks.task_title','time_sheets.id as timesheet_id','time_sheets.created_at','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status')
                ->where('projects.id',$project)
                ->where('project_modules.id',$module)
                ->get();
            return $timesheet;
        }


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
        $validator=Validator::make(Input::except('_token'),['status'=>'required','hours'=>'required','minutes'=>'required','comment'=>'required']);
        if($validator->fails()){
            return Redirect::back()->withInput()->with('error','please provide the data');
        }
        TimeSheet::where('id',Input::get('timesheet_id'))
            ->update(['comment'=>Input::get('comment'),'status'=>Input::get('status'),'hours'=>Input::get('hours'),'minutes'=>Input::get('minutes')]);
        return Redirect::route('timesheet_display');

}

}

<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tasks;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Project;
use Validator;
use Session;
use App\ProjectModules;
use Excel;
use Auth;
use Entrust;
use App\ProjectUser;

class ProjectModuleController extends Controller {

    //

    public function index(){
        $projects=Project::select('id','name')->get();
        return view('project_modules.module_creation',compact('projects'));
    }


    // adding new module to the project.
    public function add(Request $request){
        $data=$request->except('_token');
        $messages = [
            'project_id.required'=>'Please choose a project',
            'name.required' => 'Enter Name of the Module',
            'description.required' => 'Please give a Description',
        ];
        $rules = [
            'project_id'=>'required',
                'name'=>'required|unique:project_modules',
                'description'=>'required|min:5'
            
        ];
        $validator=Validator::make($data,$rules,$messages);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }

        else ProjectModules::create($data);
        return Redirect::to('module')->with('success','Module Created Successfully');
    }

    public  function display(){
        $users=Auth::user();
        $uid=$users->id;
        if (Entrust::hasRole('Admin')) {
            $module = projectModules::get();
            return view('project_modules.modulesdisplay', compact('module'));
        }
        else{
            $projectid=ProjectUser::where('user_id',$uid)->lists('project_id');
            /*dd($projectid);*/
            $module=projectModules::where('project_id',$projectid)
                ->get();
            return view('project_modules.modulesdisplay', compact('module'));
        }
    }
    public function destroy($id)
    {
        /*$project = Project::where('id')->count();*/
        $tasks=Tasks::where('module_id',$id)->count();
        if($tasks == null){
        projectModules::find($id)->delete();
         \Session::flash('message', 'Deleted!');
         return Redirect::to('module');
        }
        else
        {
            \Session::flash('alert-class', 'Cannot Delete this Module');
        return Redirect::back();
        }
    }

    public function edit($id)
    {
        $module=projectModules::find($id);
        return view('project_modules.module_edit',compact('module'));
    }

    public function update($id)
    {
       $module=projectModules::find($id);
        $post=Input::all();
        $message=['description.required'=>'Please give a description'];
        $rule=[
            'description'=>'required|min:5',
            'name'=>'required|max:255|unique:project_modules,name,' . $id
        ];
        $validator=Validator::make($post,$rule,$message);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }
        unset($post['_token']);
        $record = projectModules::where('id',$id)->update([
            'name'=>$post['name'],
            'description'=>$post['description'],
        ]);

        return Redirect::to('module');


    }

    public function downloadExcel($type)
    {
        $users=Auth::user();
        $uid=$users->id;
        if (Entrust::hasRole('Admin')) {
            $data = projectModules::select('Name','Description')->get()->toArray();
            return Excel::create('ProjectModules', function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->download($type);
        }
        else{
            $projectid=ProjectUser::where('user_id',$uid)->lists('project_id');
            /*dd($projectid);*/
            $data=projectModules::select('Name','Description')
                ->where('project_id',$projectid)
                ->get()->toArray();
            return Excel::create('ProjectModules', function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->download($type);
        }

      /*  $data = projectModules::select('Name','Description')->get()->toArray();
        return Excel::create('ProjectModules', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);*/
    }

}

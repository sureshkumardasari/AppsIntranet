<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Project;
use App\Item;
use DB;
use Excel;
use App\ProjectUser;
use Validator;
use Session;
use App\ProjectModules;

class ProjectModuleController extends Controller {

    //

    public function index(){
        $projects=Project::select('id','name')->get();
        return view('project_modules.module_creation',compact('projects'));
    }


    // adding new module to the project.
    public function add(Request $request){
        $data=$request->except('_token');
        //return $data;
/*        $rules=['project_id'=>'required','name'=>'required|unique:project_modules','description'=>'required'];
        $messages=['project_id.required'=>'please provide the name','name.required'=>'kuhkjnkh'];
        $validator=Validator::make($data,$rules,$messages);*/
        $validator=Validator::make($data,[
                'project_id'=>'required','name'=>'required|unique:project_modules','description'=>'required']
        );
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }
        /*if($validator->fails())
        {
            Session::flash('fail','please provide all the fileds');
            return Redirect::back()->withInput();
        }*/
        else ProjectModules::create($data);
        return Redirect::to('module')->with('success','Module Created Successfully');
    }

    public  function display(){
        $module=projectModules::get();
        return view('project_modules.modulesdisplay',compact('module'));

    }
    public function destroy($id)
    {   
        $project = ProjectUser::where('project_id',$id)->count();
        if($project == null){
        projectModules::find($id)->delete();
         \Session::flash('message', 'Deleted!');
        }
        else
        {
            \Session::flash('alert-class', 'Cannot Delete this Module');
        return Redirect::to('module');
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
        $validator=Validator::make($post,[
                'description'=>'required|min:5']
        );
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
        $data = projectModules::get()->toArray();
        return Excel::create('ProjectModules', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

}

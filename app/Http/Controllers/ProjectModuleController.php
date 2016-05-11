<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Project;
use Validator;
use Session;
use App\ProjectModules;
use Excel;
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
        $validator=Validator::make($data,[
                'project_id'=>'required','name'=>'required|unique:project_modules','description'=>'required|min:5']
        );
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }

        else ProjectModules::create($data);
        return Redirect::to('module')->with('success','Module Created Successfully');
    }

    public  function display(){
        $module=projectModules::get();
        return view('project_modules.modulesdisplay',compact('module'));

    }
    public function destroy($id)
    {
        /*$project = Project::where('id')->count();*/
        $projects=Project::select('id')->count();
        if($projects == null){
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
        $data = projectModules::select('name','description')->get()->toArray();
        return Excel::create('ProjectModules', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

}

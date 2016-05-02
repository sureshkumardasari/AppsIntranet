<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Project;
use Validator;
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
        $rules=['project_id'=>'required','name'=>'required','description'=>'required'];
        $messages=['project_id.required'=>'please provide the name','name.required'=>'kuhkjnkh'];
        $validator=Validator::make($data,$rules,$messages);
        if($validator->fails()){
            return Redirect::back()->withInput();
        }
        else ProjectModules::create($data);
        return Redirect::back()->with('success','Module Created Successfully');
    }

}

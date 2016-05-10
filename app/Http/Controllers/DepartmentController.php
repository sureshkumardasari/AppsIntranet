<?php namespace App\Http\Controllers;

use App\Department;
use App\User;
use App\Projectdepartment;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Excel;
class DepartmentController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	public function index()
	{
		return view('department');
	}
	public function departmentSubmit()
	{
		$depart_list=Input::All();
 		$validator=Validator::make($depart_list,[
						'name'=>'required|unique:departments|max:50',
						'depart_description'=>'required|min:5']
		);
		if ($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$depart = Department::create([
				'name' => $depart_list['name'],
				'description' => $depart_list['depart_description'],
		]);
		\Session::flash('success','Department successfully added.');
		return Redirect::to('department');
	}

	public  function display(){
		$department=Department::get();
		return view('departmentdisplay',compact('department'));

	}

	public function destroy($id)
	{
		/*Department::find($id)->delete();
		return Redirect::to('department');*/
		 $user_department = User::where('department_id', $id)->count();
		
			$project = ProjectDepartment::where('depart_id', $id)->count();
         //return $users;
			
        if ($user_department == null && $project == null) { 
        	
            Department::find($id)->delete();
            \Session::flash('message', 'Deleted!');
            return redirect('department');

        } else {
        	
            \Session::flash('alert-class', 'Cannot Delete this Department');
            // \Session::flash('flash_message', 'Cannot delete this user.');
            return Redirect::back();
        }
	}

	public function edit($id)
	{
		$department=Department::find($id);
		return view('department_edit',compact('department'));
	}

	public function update($id)
	{
		$department=Department::find($id);
		$post=Input::all();
		$validator=Validator::make($post,[
						'depart_description'=>'required|min:5']
		);
		if ($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		unset($post['_token']);
		$record = Department::where('id',$id)->update([
				'name'=>$post['name'],
				'description'=>$post['depart_description'],
		]);
		/*$record = $department->update($post);*/
		return Redirect::to('department');

		/*$department = Department::find($id);
		$post = Input::all();
		unset($post['_token']);
		unset($post['_method']);
		$record = Department::where('id', $id)->update($post);
		return Redirect::to('department_display');*/
	}

	public function downloadExcel($type)
	{
		$data = Department::select('name','description','created_at','updated_at')->get()->toArray();
		return Excel::create('departmentlist', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}
}

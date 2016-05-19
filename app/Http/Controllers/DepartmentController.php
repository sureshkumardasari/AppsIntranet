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
		$messages = [
			'name.required' => 'Enter Name of the Department',
			'depart_description.required' => 'Please give a Description',
		];
		$rules = [
			'name'=>'required|unique:departments|max:50',
						'depart_description'=>'required|min:5'
			
		];
 		$validator=Validator::make($depart_list,$rules,$messages);
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
		$messages = [
			
			'depart_description.required' => 'Please give a Description',
		];
		$rules = [
				'depart_description'=>'required|min:5',
				'name'=>'required|max:255|unique:departments,name,' . $id
		];


		$validator=Validator::make($post,$rules,$messages);
		if ($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		unset($post['_token']);
		$record = Department::where('id',$id)->update([
				'name'=>$post['name'],
				'description'=>$post['depart_description'],
		]);
		return Redirect::to('department');
	}

	public function downloadExcel($type)
	{
		$data = Department::select('Name','Description','Created_At','Updated_At')->get()->toArray();
		return Excel::create('departmentlist', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}
}

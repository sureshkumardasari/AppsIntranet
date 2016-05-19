<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\RoleUser;
use App\Department;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App;
use Excel;
use App\User;
use App\UserDepartments;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$post=Input::All();
		$messages = [
			
			  'username.required'=>'Please Give a User Name ',
                'first_name.required'=>'Please Give a First Name ',
                'last_name.required'=>'Please Give a Last Name ',
                'email.required'=>'Please Give an Email ',
                'password.required'=>'Please Give a Password ',
				'user_depart_name.required'=>'Please choose Department ',
		];
		$rules = [ 
				 'username' => 'required|max:255|unique:users',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
				'user_depart_name'=>'required'
		];
 		$validator=Validator::make($post,$rules,$messages);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }
//		$depart_list = Department::where('name', '=', $post['user_depart_name'])->first();

		$user = User::create([
				'username'=>$post['username'],
				'first_name'=>$post['first_name'],
				'last_name'=>$post['last_name'],
				//'department_id'=>$ids,
				'role_id'=>$post['roles'],
  				'password'=>bcrypt($post['password']),
				'email'=>$post['email'],
				'status'=>'active',
				'gender'=> input::get('gender'),
				'date_of_birth'=>$post['dob'],
				'joining_date'=>$post['jod'],
		]);
 		$roles=new RoleUser;
		$last_id=$user->id;
		$roles->user_id=$last_id;
		$roles->role_id=$post['roles'];
		$roles->timestamps = false;
		$roles->save();
		if ($user) {
			$depart = $post['user_depart_name'];
			$user_id = $user['id']; //$depart_list['userids'];
			//$lastInsertedId = $user->id;
			foreach ($depart as $departs) {
				$users_depart = new UserDepartments();
				$users_depart->user_id = $user_id;
				$users_depart->depart_id = $departs;
				$users_depart->save();
			}
			\Session::flash('success', 'User successfully added.');
			return Redirect::to('users');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$users=User::join('roles','roles.id','=','users.role_id')
			->whereNotIn('users.id',['1','2','3','4'])
			//->join('departments','departments.id','=','users.department_id')
			->select('users.id as user_id','users.username as username','users.email','users.status as user_status','roles.display_name as role_name')
			->get();
		//dd($userr);
		////$departments=Departments::join('user_departments','user_departments.depart_id','=','departments.id')
		//->where('user_departments.user_id',)
		//->get();
		// departments------
		$departments=array();
		foreach($users as $user){
			array_push($departments,App\Department::join('user_departments','user_departments.depart_id','=','departments.id')->where('user_departments.user_id',$user->user_id)
				->select('departments.id as depart_id','departments.name as depart_name')
				->get());
		}
		//dd($departments);
		//--------
		$projects=array();
		foreach($users as $user){
		array_push($projects,App\Project::join('projects_users','projects.id','=','projects_users.project_id')->where('projects_users.user_id',$user->user_id)
			->select('projects.id as project_id','projects.name as project_name')
			->get());
		}
		//dd($projects);
		//$user=User::get();

		return view('users/Usersview',compact('users','departments','projects'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$users=User::find($id);
		$clients=User::select('client_id')->where('id',$id)->get();
		$userdeparts=UserDepartments::select('depart_id')->where('user_id','=',$users->id)->get();
		//dd($userdeparts);
		return view('users.edit',compact('users','userdeparts','clients'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$users=User::find($id);
		$post=Input::all();
		$messages = [
				'first_name.required'=>'Please Give a First Name ',
                'last_name.required'=>'Please Give a Last Name ',
                'email.required'=>'Please Give an Email ',
   				'user_depart_name.required'=>'Please choose Department ',
		];

		$rules = [
				'first_name' => 'required|max:255',
				'last_name' => 'required|max:255',
				'user_depart_name' =>'required',
				'email'=>'required|max:255|unique:users,email,'.$id,
				'username'=>'required|max:255|unique:users,username,' . $id
		];


		if($post['password'] != NULL)
		{
			$rules['password'] = 'confirmed|min:6';
		}


		$validator = Validator::make($post, $rules,$messages);

		/*$validator=Validator::make($post,[
						'first_name' => 'required|max:255',
						'last_name' => 'required|max:255',
						'user_depart_name' =>'required',
						'email'=>'required|unique:users',
						]
		);*/
		if ($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		unset($post['_token']);

		$update = [
			'first_name'=>$post['first_name'],
			'last_name'=>$post['last_name'],
			'email'=>$post['email'],
			'role_id'=>$post['roles'],
			'gender'=>$post['gender'],
			'date_of_birth'=>$post['dob'],
			'joining_date'=>$post['jod']
		];
		if($post['password'] != "")
		{
			$update['password'] = bcrypt($post['password']);
		}
		$record = User::where('id',$id)->update($update);

		if(isset($post['user_depart_name'])){
		if($record){
			$user_departments=$post['user_depart_name'];
			//dd($user_departments);
			UserDepartments::where('user_id',$id)->delete();
			foreach($user_departments as $user_depart){
				UserDepartments::create([
				'user_id'=>$id,
				'depart_id'=>$user_depart
			]);
			}


		}
		}
		else{
			UserDepartments::where('user_id',$id)->delete();
		}
		return Redirect::to('users');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
		$user_department = Department::select('id');
		//return $users;
       /* $user_dependency=Department::find($user_department->department_id);*/
       // dd($user_dependency);
		if ($user_department == null) {
			User::find($id)->delete();
			\Session::flash('flash_message', 'Deleted.');
			return redirect('users');

		} else {
			\Session::flash('flash_message_failed', 'Cannot Delete this user.');
			return Redirect::back();

		}
	}

	public function userlist($department_id=null,$project_id=null,$task_id=null){
		$users="";
		if($department_id){
			if($project_id==null||$project_id==0){
				$users=User::join('user_departments','user_departments.user_id','=','users.id')->where('user_departments.depart_id',$department_id)
					->select('users.id','users.first_name')->groupBy('id')->get();
			}
			else
			{
				if($task_id==null||$task_id==0){
					$users=User::join('projects_users','projects_users.user_id','=','users.id')->select('users.id','users.first_name')
						->where('projects_users.project_id',$project_id)->groupBy('id')->get();
				}
				else{
					$users=User::join('tasks','tasks.user_id','=','users.id')->select('users.id','users.first_name')
						->where('tasks.id',$task_id)->groupBy('id')->get();
				}
			}
		}
		return $users;
	}

	public function downloadExcel($type)
	{
		$data = User::select('Id','UserName','Email','First_Name','Last_Name','Creation_Date','Status','Department_Id','Role_Id','Gender','Date_of_Birth','Joining_Date','Created_At','Updated_At')->get()->toArray();
		return Excel::create('userslist', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}
}

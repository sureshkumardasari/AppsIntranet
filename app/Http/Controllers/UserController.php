<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\RoleUser;
use App\Department;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App;
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
        $validator=Validator::make($post,[
                'username' => 'required|max:255|unique:users',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6']
        );
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }
//		$depart_list = Department::where('name', '=', $post['user_depart_name'])->first();
   		$ids=implode(',',$post['user_depart_name']);
		$user = User::create([
				'username'=>$post['username'],
				'first_name'=>$post['first_name'],
				'last_name'=>$post['last_name'],
				'department_id'=>$ids,
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
		$user=User::get();

		return view('users/Usersview',compact('user'));
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
		return view('users.edit',compact('users'));
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
        $validator=Validator::make($post,[
                'username' => 'required|max:255|unique:users',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                ]
        );
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }

		unset($post['_token']);
		$record = User::where('id',$id)->update([
				'username'=>$post['username'],
				'first_name'=>$post['first_name'],
				'last_name'=>$post['last_name'],
			/* 'user_depart_name'=>$post['department_id'],*/
				'password'=>$post['password'],
				'email'=>$post['email'],
				'gender'=>$post['gender'],
				'date_of_birth'=>$post['dob'],
				'joining_date'=>$post['jod'],

		]);
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
		/*$user=User::find($id);
		$user->delete($id);

		return Redirect::to ('users');*/
		$user_department = User::select('department_id')->where('id', $id)->first();
		//return $users;
        $user_dependency=Department::find($user_department->department_id);
       // dd($user_dependency);
		if ($user_dependency == null) {
			User::find($id)->delete();
			\Session::flash('flash_message', 'Deleted.');
			return redirect('users');

		} else {
			\Session::flash('flash_message_failed', 'Cannot Delete this user.');
			return Redirect::back();

		}
	}
	public function exportcsv()
	{
	}
}

<?php namespace App\Http\Controllers;

use App\User;
use App\Department;

use form;
use Input;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Validator;

class HomeController extends Controller {

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

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
//	public function __construct()
//	{
//		$this->middleware('auth');
//	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users=User::get();

		return view('home',compact('users'));

	}

	public function create()
	{
        $users=Input::All();

		return view('auth/register');
	}

	/* public function show($id)
     {
         return view('projects.show', compact('project'));
     }*/

	public function edit($id)
	{
		$users=User::find($id);
		return view('users.edit',compact('users'));
	}


	public function profile($id)
	{
        //r//eturn $id;
		//$users=User::find($id);

		return view('users.profile',compact('users'));
	}


	public function update($id)
	{
		$users=User::find($id);
		$post=Input::all();
		unset($post['_token']);
		$record = User::where('id',$id)->update([
				'username'=>$post['username'],
				'first_name'=>$post['first_name'],
				'last_name'=>$post['last_name'],
				'department_id'=>$post['user_depart_name'],
			/* 'user_depart_name'=>$post['department_id'],*/
				'password'=>$post['password'],
				'email'=>$post['email'],

		]);
		return Redirect::to('home');
	}

	public function destroy($id)
	{
		$user=User::find($id);
		$user->delete($id);

		return Redirect::route('home');
	}

	public function show()
	{
		$users=User::get();
		return view('Usersview',compact('users'));
	}
	public function userLoginCheck(){
//		$status=User::get('status');
  	$auth = Auth::attempt(
		[
			'username'  => strtolower(Input::get('username')),
			'password'  => Input::get('password'),
 		]
	);
 	if ($auth ) {
		$user=Input::get('username');
		$getstatus=User::select('status')->where('username','=',$user)->get();
		$status=$getstatus[0]['status'];
			if($status==1) {
			return Redirect::to('/');
			}
			else{
				return Redirect::back()->with('Failed','Admin denied Permission');
			}
	}
	else {
		return Redirect::back()->with('Failed','Not Registered User') ;
	}
	}
 public function status($id)
 {
 	$users=User::find($id);
 	 $oldstatus=$users->status;
  	 if ($oldstatus == '1') {
 		 $status_state = 0;
	 } else {
 		 $status_state = 1;
	 }
	 $record=User::find($id);
	 $record->status=$status_state;
	 $record->save();
	 return Redirect::to('users');
 }
	public function profile_view()
	{
		$users=Auth::user();
		$id=$users->id;
		return view('ProfileView',compact('users'));
	}
	public function profile_update($id)
	{
		$users=User::find($id);
		$post=Input::all();
		$validator=Validator::make($post,[
						'first_name'=>'required',
						'last_name'=>'required'
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
				'password'=>$post['password'],
				'email'=>$post['email'],

		]);
		return Redirect::back()->with('success','updated successfully');
	}
}

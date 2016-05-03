<?php namespace App\Http\Controllers;

use App\User;
use form;
use Input;
use Redirect;
use Illuminate\Support\Facades\Auth;

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
		$users=App::get();
		return view('Usersview',compact('users'));
	}
	public function userLoginCheck(){
  	$auth = Auth::attempt(
		[
			'username'  => strtolower(Input::get('username')),
			'password'  => Input::get('password')
		]
	);
 	if ($auth) {
 		return Redirect::to('validate');
	} else {
		return "NOT REGISTER USER" ;
	}
}

}

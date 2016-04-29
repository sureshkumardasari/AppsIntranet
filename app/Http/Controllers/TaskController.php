<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\ProjectUser;
use App\ProjectDepartment;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Tasks;
use Validator;
use Session;


class TaskController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$users=User::select('id','username')->get();
		//dd($users);
		return view('assign_task',compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	public function projectList($id){
	$a=	ProjectUser::join('projects','projects_users.project_id','=','projects.id')
			->where('projects_users.user_id','=',$id)
			->select('projects.id','name')
			->get();
		//json_encode($a);
//dd($a);
		return $a;
	}
	public function add(){
		$data=Input::All();
		$validator=Validator::make($data,['user_id'=>'required','project_id'=>'required','description'=>'required','date'=>'required']);
		if($validator->fails())
		{
			Session::flash('fail','please provide all the fileds');
			return Redirect::back()->withInput();
		}
		//dd($data);
		$data['date']=date('y-m-d',strtotime($data['date']));
		$exec=Tasks::create($data);
		Session::flash('success','Task added successfully');
		return Redirect::back();

	}

}

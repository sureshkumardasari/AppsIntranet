<?php namespace App\Http\Controllers;

use App\Client;
use App\Project;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
class ClientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('client');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$post=Input::All();
			$messages=[
					'clientname.required'=>'Client Name can\'t leave as blank!',
						'email.required'=>'Email can\'t leave as blank!',
						'phone1.required'=>'Phone1 can\'t leave as blank!',
						'phone2.required'=>'Phone2  can\'t leave as blank!',
						/*'fax.required'=>'Fax can\'t leave as blank!',	*/	
		];
		$rules=[
				'clientname' => 'required|max:255|unique:clients',
                'email' => 'required|email|max:255|unique:clients',
				'phone1'=>array('required','numeric','regex: /^\d{10}$/'),
				'phone2'=>array('required','numeric','regex: /^\d{10}$/'),
                /* 'fax'=>array('required','regex: /\+[0-9]{1,2}-[0-9]{3}-[0-9]{7}/'),*/
               
		];
		$validator=Validator::make($post,$rules,$messages);
      
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }

		$client = Client::create([
				'clientname'=>$post['clientname'],
				'email'=>$post['email'],
				'phone1'=>$post['phone1'],
				'phone2'=>$post['phone2'],
				'fax'=>$post['fax'],
				'skypeid'=>$post['skypeid'],
				'address'=>$post['address'],

				
		]);
 		
			\Session::flash('success', 'Client Details successfully added.');
			return Redirect::to('clientview');
		
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
	public function display()
	{
		$client=Client::get();
		return view('clientview',compact('client'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client=Client::find($id);
		return view('clientedit',compact('client'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$client=Client::find($id);
		$post=Input::all();
		$messages=[
				'email.required'=>'Email can\'t leave as blank!',
				'phone1.required'=>'Phone1 can\'t leave as blank!',
				'phone2.required'=>'Phone2 can\'t leave as blank!',
			/*'fax.required'=>'Fax can\'t leave as blank!',*/
		];
		$rules=[
				'clientname'=>'required|max:255|unique:clients,clientname,' . $id,
				'email' => 'required|max:255|'/*unique:clients,email'*/,
				'phone1'=>array('required','numeric','regex: /^\d{10}$/'),
				'phone2'=>array('required','numeric','regex: /^\d{10}$/'),
			/*'fax'=>array('required','regex: /\+[0-9]{1,2}-[0-9]{3}-[0-9]{7}/'),*/

		];
		$validator=Validator::make($post,$rules,$messages);
		
		if ($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		unset($post['_token']);
		$record = Client::where('id',$id)->update([
				'clientname'=>$post['clientname'],
				'email'=>$post['email'],
				'phone1'=>$post['phone1'],
				'phone2'=>$post['phone2'],
				'fax'=>$post['fax'],
				'skypeid'=>$post['skypeid'],
				'address'=>$post['address'],
				
		]);
		/*$record = $department->update($post);*/
		return Redirect::to('clientview');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$project=Project::where('client_id',$id)->count();
		if ($project == null) {
			Client::find($id)->delete();
		
		\Session::flash('flash_message', 'Deleted.');
		return Redirect::to('clientview');

	}
	else
		{
			\Session::flash('flash_message_failed', 'Cannot Delete this Client');
		
		return Redirect::back();

		}
	}

}

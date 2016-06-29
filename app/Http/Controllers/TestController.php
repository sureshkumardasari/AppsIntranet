<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestController extends Controller {

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


	public function errorlog() {       
        $fullPath = storage_path(). '/logs/laravel-'.date('Y-m-d').'.log';
        $params['Download'] = true;
        $pathTmp = 'data/tmp/';

        $zip = new \ZipArchive();
        $zipFileName = time() . ".zip";
        $path = public_path($pathTmp);
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }
        $zipFileNameFullPath = $path . $zipFileName; // Zip name
        $zip->open($zipFileNameFullPath, \ZipArchive::CREATE);
        $fullPath = str_replace('\\', '/', $fullPath);//exit;
        // if (file_exists($fullPath)) {
        $zip->addFromString(basename($fullPath), file_get_contents($fullPath));
        $zip->close();

        if (file_exists($zipFileNameFullPath)) {
            $response['success'] = 'Yes';
            $response['zipFileFullPath'] = $zipFileNameFullPath;
        } else {
            $response['errors'] = array('Zip-File was not successfully created.');
        }

        if (isset($params['Download']) && $params['Download'] == true) {

            $filePathInfo = pathinfo($zipFileNameFullPath);
            $fileName = $filePathInfo['basename'];

            // Poooof!!! All done now download that file :)
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-length: " . filesize($zipFileNameFullPath));
            header("Pragma: no-cache");
            header("Expires: 0");
            readfile("$zipFileNameFullPath");
        }

        return $response;
    }

}

<?php namespace App\Http\Controllers;

use App\Age;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AgeController extends Controller {

	public function __construct()
	{
		// reqires Authentificataion before access
		//Config::set('session.driver', 'array');
		$this->middleware('once');
		//$this->middleware('auth.basic');

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try{
			$statusCode = 200;
//			$response = [
//				'Age List'  => []
//			];

			$ages = Age::all();

			foreach($ages as $age){
//
				$response['Age List'][] = [
					'id' => $age->id,
					'Age' => $age->age,

				];
			}
//			$response=$gender;

		}catch (Exception $e){
			$statusCode = 400;
		}finally{
			return Response::json($response, $statusCode);
		}


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
		$age=Age::find($id);
		//return $gender;
		if(count($age) > 0)
		{
			$statusCode = 200;
			$response = [
				'id' => $age->id,
				'Age' => $age->age,
			];
		}
		else
		{
			$response = [
				"error" => "Age doesn`t exist"
			];
			$statusCode = 404;

		}
		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}




}

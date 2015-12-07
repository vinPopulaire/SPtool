<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Occupation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OccupationsApiController extends Controller {
	public function __construct()
	{
		// reqires Authentificataion before access
		//Config::set('session.driver', 'array');
		$this->middleware('once');
		//$this->middleware('auth.basic');

	}

	public function index()
	{


		try{
			$statusCode = 200;
//			$response = [
//				'Occupations List'  => []
//			];

			$occupations = Occupation::all();

			foreach($occupations as $occupation){
//
				$response['Occupations List'][] = [
					'id' => $occupation->id,
					'Occupation' => $occupation->occupation,

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
		$occupation=Occupation::find($id);
		//return $gender;
		if(count($occupation) > 0)
		{
			$statusCode = 200;
			$response = [
				'id' => $occupation->id,
				'Occupation' => $occupation->occupation,
			];
		}
		else
		{
			$response = [
				"error" => "Occupation doesn`t exist"
			];
			$statusCode = 404;

		}
		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}




}

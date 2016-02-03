<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use App\Gender;
use Illuminate\Support\Facades\Response;

class GenderApiController extends ApiGuardController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		try{
			$statusCode = 200;
			$response = [
				'Gender List'  => []
			];

			$genders = Gender::all();

		foreach($genders as $gender){
//
				$response['Gender List'][] = [
					'id' => $gender->id,
					'Gender' => $gender->gender,

				];
			}
//			$response=$gender;

		}catch (Exception $e){
			$statusCode = 400;
		}finally{
			return Response::json($response, $statusCode);
		}


	}


	public function show($id)
	{
		$gender=Gender::find($id);
		//return $gender;
		if(count($gender) > 0)
		{
			$statusCode = 200;
			$response = [
				'id' => $gender->id,
				'Gender' => $gender->gender,
			];
		}
		else
		{
			$response = [
				"error" => "Gender doesn`t exist"
			];
			$statusCode = 404;

		}
		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}



}

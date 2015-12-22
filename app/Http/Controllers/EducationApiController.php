<?php namespace App\Http\Controllers;

use App\Education;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EducationApiController extends Controller {

	public function __construct()
	{
		// reqires Authentificataion before access
		//Config::set('session.driver', 'array');
		$this->middleware('auth');
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
//				'Education List'  => []
//			];

			$educations = Education::all();

			foreach($educations as $education){
//
				$response['Education List'][] = [
					'id' => $education->id,
					'Education' => $education->education,

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
		$education=Education::find($id);
		//return $gender;
		if(count($education) > 0)
		{
			$statusCode = 200;
			$response = [
				'id' => $education->id,
				'Education' => $education->education,
			];
		}
		else
		{
			$response = [
				"error" => "Education doesn`t exist"
			];
			$statusCode = 404;

		}
		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}




}
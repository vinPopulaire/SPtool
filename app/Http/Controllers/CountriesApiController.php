<?php namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;



class CountriesApiController extends Controller {

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
//				'Countries List'  => []
//			];

			$countries = Country::all();

			foreach($countries as $country){
//
				$response['Country List'][] = [
					'id' => $country->id,
					'Country' => $country->country,

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
		$country=Country::find($id);
		//return $gender;
		if(count($country) > 0)
		{
			$statusCode = 200;
			$response = [
				'id' => $country->id,
				'Country' => $country->country,
			];
		}
		else
		{
			$response = [
				"error" => "Country doesn`t exist"
			];
			$statusCode = 404;

		}
		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}




}

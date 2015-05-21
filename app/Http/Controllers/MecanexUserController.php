<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\MecanexUser;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

use App\Http\Requests\MecanexUserRequest;
//use Validator;

//use Illuminate\Config;
use Illuminate\Support\Facades\Config;

class MecanexUserController extends Controller
{

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

		//return 'Hello API';

	{

		try {
			$statusCode = 200;
			$response = [
				'Mecanex_Users' => []
			];

			$mecanexusers = MecanexUser::all();

			foreach ($mecanexusers as $mecanexuser) {

				$response['Mecanex_Users'][] = $mecanexuser;
//					[
//					'email' => $mecanexuser->email,
//					'name' => $mecanexuser->name,
//					'surname' => $mecanexuser->surname,
//					'gender' => $mecanexuser->gender_id,
//					'age' => $mecanexuser->age_id,
//					'education' => $mecanexuser->education_id,
//					'occupation' => $mecanexuser->occupation_id,
//					'country' => $mecanexuser->country_id,
//										];
			}

		} catch (Exception $e) {
			$statusCode = 400;
		} finally {
			return Response::json($response, $statusCode);
		}

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(MecanexUserRequest $request)
	{

		$mecanexuser = MecanexUser::create($request->all());


		$response = array(
			'message' => 'Store successful');
		return response($response, 201)->header('Content-Type', 'application/json');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($username)
	{

		$mecanexuser = MecanexUser::where('username', $username)
			->get();
		//return $mecanexuser;


		//should check if email exists
		if ($mecanexuser->isEmpty()) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;
		} else {
			$mecanexuser = $mecanexuser->first();
			$statusCode = 200;
			$response = $mecanexuser;

		}
		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update(MecanexUserRequest $request, $username)
	{
		//

		$mecanexuser = MecanexUser::where('username', $username)
			->get();

		if ($mecanexuser->isEmpty()) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;
		} else {
			//
			$mecanexuser = $mecanexuser->first();
			$mecanexuser->update($request->all());

		//$mecanexuser->save();
		$statusCode = 200;
		$response = $e = array(
			'message' => 'User updated',
			'Updated User' => $mecanexuser);


}

		return response($response, $statusCode)->header('Content-Type', 'application/json');
		//Correct the response: Do I need to show the user? Check transform from laracasts
	}





}

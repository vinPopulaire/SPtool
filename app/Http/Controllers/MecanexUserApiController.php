<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\MecanexUser;
use App\User;
use App\Term;
use App\MecanexUserTermHomeTermNeighbour;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

use App\Http\Requests\MecanexUserRequest;
//use Validator;

//use Illuminate\Config;
use Illuminate\Support\Facades\Config;

class MecanexUserApiController extends ApiGuardController
{

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

//		$thematic_area=$request->interest;
//		dd($thematic_area);
		$mecanexuser = MecanexUser::create($request->all());
		$username=$request->username;
		$user = User::where('username', $username)->get()->first();


		// create records in table users_terms-scores once a mecanex user has been created
		$terms=Term::all();
		$total_terms=$terms->count();

		foreach ($terms as $term)
		{

			$mecanexuser->term()->sync([$term->id=>['user_score'=>0]],false);
			$mecanexuser->profilescore()->sync([$term->id=>['profile_score'=>0]],false);

		}


		//create record in table mecanex_user_term_home_term_neighbor once a mecanex user has been created

		for ($i=1;$i<=$total_terms; $i++)
		{
			for ($j=$i+1;$j<=$total_terms; $j++)
			{
				$mec_matrix=new MecanexUserTermHomeTermNeighbour();
				$mec_matrix->mecanex_user_id=$mecanexuser->id;
				$mec_matrix->term_home_id=$i;
				$mec_matrix->term_neighbor_id=$j;
				$mec_matrix->link_score=0.1;
				$mec_matrix->save();
			}

		}

		//the following is only needed for linking an existing authorized user (users_table) with a new mecanex user provided they have the same username
		if (empty($user)) {
			$response = array(
				'message' => 'Store successful');
		}
		else{
			$mecanexuser->user_id=$user->id;
			$mecanexuser->save();
			$response = array(
				'message' => 'Store successful');

		}


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

	}


	public function destroy($username)
	{
		//

		$mecanexuser=MecanexUser::where('username', $username)->get()->first();


		if (empty($mecanexuser)) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;

		}
		else {
			//
			$mecanexuser->delete();
			$statusCode = 200;
			$response = [
				"message" => "User deleted"
			];


		}

		return response($response, $statusCode)->header('Content-Type', 'application/json');



	}


}

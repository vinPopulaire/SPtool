<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUser;
use Illuminate\Http\Request;
use App\Interest;
use Illuminate\Support\Facades\Response;
use App\Term;
use App\Http\Requests\InterestRequest;
class InterestApiController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	//I should have only update and not create
	public function index()
	{

		$response=["message"=>"method is not supported"];
		$statusCode = 501; //not implemented by the server

		return response($response, $statusCode)->header('Content-Type', 'application/json');
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
	public function store(InterestRequest $request)
	{
		$interests = $request->except('username');
		$username=$request->username;
		$user=MecanexUser::where('username', $username)->get()->first();


			if (empty($user)) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;
		}

		else {


			foreach ($interests as $key => $value) {
				$interest = Interest::where('short_name', $key)->get(array('id'))->first();
				$user->interest()->sync([$interest->id=>['interest_score'=>$value]],false);
				$term=Term::where('term',$key)->firstOrFail();
				$user->term()->sync([$term->id=>['user_score'=>$value]],false);
			}


			$response='User Interests were saved';
			$statusCode = 201;
		}
		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($username)
	{
		$user=MecanexUser::where('username', $username)->get()->first();


		if (empty($user)) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;
		}

		elseif (count ($user->interest)==0)
		{
			$response = [
				"message" => "User has not set any interests"
			];
			$statusCode = 404;

		}
		else {

			$interests = $user->interest;
			foreach ($interests as $interest)
			{
				$user_interest=[];
				$temp[$interest['short_name']]=$interest['pivot']['interest_score'];
				array_push($user_interest,$temp);
			}

			$response = $user_interest;
			$statusCode = 200;
		}

		return response($response, $statusCode)->header('Content-Type', 'application/json');
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
	public function update(InterestRequest $request, $username)
	{
		{
			$interests = $request->except('username');
			$user=MecanexUser::where('username', $username)->get()->first();


			if (empty($user)) {

				$response = [
					"error" => "User doesn`t exist"
				];
				$statusCode = 404;
			}
			elseif (count ($user->interest)==0)
			{
				$response = [
					"message" => "User has not set any interests, To create interests, try store"
				];
				$statusCode = 404;

			}
			else {
				foreach ($interests as $key => $value) {
					$interest = Interest::where('short_name', $key)->get(array('id'))->first();
					$user->interest()->sync([$interest->id=>['interest_score'=>$value]],false);
					$term=Term::where('term',$key)->firstOrFail();
					$user->term()->sync([$term->id=>['user_score'=>$value]],false);
				}


				$response='User Interests were saved';
				$statusCode = 201;
			}
			return response($response, $statusCode)->header('Content-Type', 'application/json');
		}
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

}

<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUser;
use Illuminate\Http\Request;
use App\Interest;
use Illuminate\Support\Facades\Response;
use App\Term;
use App\Http\Requests\InterestRequest;
use App\MecanexUserTermHomeTermNeighbour;

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

			$key_values=array();
			foreach ($interests as $key => $value) {

				$interest = Interest::where('short_name', $key)->get(array('id'))->first();
				$user->interest()->sync([$interest->id=>['interest_score'=>$value]],false);
				$key_values[$interest->id]=$value;
				$term=Term::where('term',$key)->firstOrFail();
				$value=$value/5;   //for normalization
				$user->term()->sync([$term->id=>['user_score'=>$value]],false);
			}

			ksort($key_values);
			$term_ids=array_keys($key_values);
			$term_ids_length=count($term_ids);


			//update adjacency matrix
			for ($i = 0; $i <= ($term_ids_length - 1); $i++) {
				for ($j = $i + 1; $j < $term_ids_length; $j++) {

					$temp_user_matrix= MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->where('term_home_id', $term_ids[$i])
						->where('term_neighbor_id', $term_ids[$j])->get()->first();

					$temp_user = $user->term->find($term_ids[$i]);
					$user_term_score_a = $temp_user->pivot->user_score;
					$temp_user = $user->term->find($term_ids[$j]);
					$user_term_score_b = $temp_user->pivot->user_score;
					$new_score = ($user_term_score_a * $user_term_score_b);
					$temp_user_matrix->link_score = $new_score;
					$temp_user_matrix->save();
				}
			}

			//update profile
			$terms=Term::all()->count();
			for ($j=1;$j<=$terms;$j++)
			{
				$profile_score=0;
				for($i=1;$i<=$terms;$i++)
				{

					$temp_user = $user->term->find($i);
					$user_term_score = $temp_user->pivot->user_score;  //get score of user

					if ($i==$j)
					{
						$link_score=0;

					}
					elseif ($i>$j)
					{
						$temp_user_matrix = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->where('term_home_id', $j)
							->where('term_neighbor_id', $i)->get()->first();
						$link_score = $temp_user_matrix->link_score;
					}

					else {
						$temp_user_matrix = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->where('term_home_id', $i)
							->where('term_neighbor_id', $j)->get()->first();
						$link_score = $temp_user_matrix->link_score;
					}

					$profile_score=$profile_score+$user_term_score * $link_score;

				}

				$user->profilescore()->sync([$j => ['profile_score' => $profile_score]], false);
			}

			$response = [
				"message" => "User Interests were saved"
			];

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
			$interests = $request->except('_method');
			$user = MecanexUser::where('username', $username)->get()->first();


			if (empty($user)) {

				$response = [
					"error" => "User doesn`t exist"
				];
				$statusCode = 404;
			} elseif (count($user->interest) == 0) {
				$response = [
					"message" => "User has not set any interests, To create interests, try store"
				];
				$statusCode = 404;

			} else {
				//check if what sends is correct or else it crushes
				//updates interests and user scores
				$key_values = array();
				foreach ($interests as $key => $value) {
					$interest = Interest::where('short_name', $key)->get(array('id'))->first();
					$key_values[$interest->id] = $value;
					$user->interest()->sync([$interest->id => ['interest_score' => $value]], false);
					$term = Term::where('term', $key)->firstOrFail();
					$value = $value / 5;
					$user->term()->sync([$term->id => ['user_score' => $value]], false);
				}


				//there must be a more clever way to do this (foreach maybe)
				//created 2 arrays one with the term ids ($term_ids) and the other with the scores ($term_scores)
				$terms = Term::get(array('id'));
				$all_terms = [];
				foreach ($terms as $term) {
					array_push($all_terms, $term->id);
				}
				$all_terms_length = count($all_terms);

				ksort($key_values);
				$term_ids = array_keys($key_values);
				$term_ids_length = count($term_ids);


				//update adjacency matrix


				for ($i = 0; $i <= ($term_ids_length - 1); $i++) {
					for ($j = 0; $j <= ($all_terms_length - 1); $j++) {


						if ($term_ids[$i] == $all_terms[$j]) {
							continue;

						} elseif ($term_ids[$i] > $all_terms[$j]) {

							$temp_user_matrix = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->where('term_home_id', $all_terms[$j])
								->where('term_neighbor_id', $term_ids[$i])->get()->first();
							$temp_user = $user->term->find($all_terms[$j]);
							$user_term_score_a = $temp_user->pivot->user_score;
							$temp_user = $user->term->find($term_ids[$i]);
							$user_term_score_b = $temp_user->pivot->user_score;
							$new_score = ($user_term_score_b * $user_term_score_a);
//						}

						} else {

							$temp_user_matrix = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->where('term_home_id', $term_ids[$i])
								->where('term_neighbor_id', $all_terms[$j])->get()->first();


							$temp_user = $user->term->find($all_terms[$j]);
							$user_term_score_a = $temp_user->pivot->user_score;
							$temp_user = $user->term->find($term_ids[$i]);
							$user_term_score_b = $temp_user->pivot->user_score;
							$new_score = ($user_term_score_b * $user_term_score_a);
						}

						$temp_user_matrix->link_score = $new_score;
						$temp_user_matrix->save();

					}
				}

				//update profile


				for ($j = 1; $j <= $all_terms_length; $j++) {
					$profile_score = 0;
					for ($i = 1; $i <= $all_terms_length; $i++) {

						$temp_user = $user->term->find($i);
						$user_term_score = $temp_user->pivot->user_score;  //get score of user

						if ($i == $j) {
							$link_score = 0;

						} elseif ($i > $j) {
							$temp_user_matrix = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->where('term_home_id', $j)
								->where('term_neighbor_id', $i)->get()->first();
							$link_score = $temp_user_matrix->link_score;
						} else {
							$temp_user_matrix = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->where('term_home_id', $i)
								->where('term_neighbor_id', $j)->get()->first();
							$link_score = $temp_user_matrix->link_score;
						}

						$profile_score = $profile_score + $user_term_score * $link_score;

					}

					$user->profilescore()->sync([$j => ['profile_score' => $profile_score]], false);
				}


				$response = [
					"message" => "User Interests were saved"
				];

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

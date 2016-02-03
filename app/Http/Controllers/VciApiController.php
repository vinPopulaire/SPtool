<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUser;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use App\Interest;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\InterestRequest;
class VciApiController extends ApiGuardController {

	public function show($username)
	{
		$user=MecanexUser::where('username', $username)->get()->first();


		if (empty($user)) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;
		}


		else {

			$terms = $user->profilescore;
			foreach ($terms as $term)
			{

				$user_profile=[];
				$temp[$term['term']]=$term['pivot']['profile_score'];
				array_push($user_profile,$temp);
			}

			$response = $user_profile;
			$statusCode = 200;
		}

		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}
}

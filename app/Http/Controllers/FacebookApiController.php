<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use SammyK;
use App\MecanexUser;
use App\Term;
use Illuminate\Support\Facades\Auth;
use App\User;

class FacebookApiController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function login(Request $request, SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
	{
		//test if token for FB login is enough

		$token = $request->token;
		//	return $token;


// does not work since $token is string but should be token
//		if (! $token->isLongLived()) {
//			// OAuth 2.0 client handler
//			$oauth_client = $fb->getOAuth2Client();
//
//			// Extend the access token.
//			try {
//				$token = $oauth_client->getLongLivedAccessToken($token);
//			} catch (Facebook\Exceptions\FacebookSDKException $e) {
//				dd($e->getMessage());
//			}
//		}

		//this is for not include $token in the get calls
		$fb->setDefaultAccessToken($token);

		// Get basic info on the user from Facebook.
		try {
			$response = $fb->get('/me?fields=id,email');

		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			dd($e->getMessage());
		}

		try {
			$profileresponse = $fb->get('/me?fields=id,name,gender');

		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			dd($e->getMessage());
		}

		// Convert the response to a `Facebook/GraphNodes/GraphUser` collection

		$facebook_user = $response->getGraphUser();
		$mecanex_user = $profileresponse->getGraphUser();


		// Create the user if it does not exist or update the existing entry.
		// This will only work if you've added the SyncableGraphNodeTrait to your User model.
		$user = User::createOrUpdateGraphNode($facebook_user);


//store profile data in mecanex_users table

		$id = $user->id;
		$facebook_id = $user->facebook_user_id;
		$fullname = $mecanex_user->getName();
		$fullname = explode(" ", $fullname);
		$name = $fullname[0];
		$surname = $fullname[1];
		$gender = $mecanex_user->getGender();
		if ($gender == 'female') {
			$gender_id = 2;
		} else {
			$gender_id = 1;
		}

		$fbuser = MecanexUser::firstOrNew(array('facebook_user_id' => $facebook_id));
		$fbuser->user_id = $id;
		$fbuser->facebook_user_id = $facebook_id;
		$fbuser->gender_id = $gender_id;
		$fbuser->name = $name;
		$fbuser->surname = $surname;
		$fbuser->save();

		// Log the user into Laravel
		Auth::login($user);
		// create records in table users_terms-scores once a mecanex user has been created
		$terms = Term::all();

		foreach ($terms as $term) {
			$fbuser->term()->sync([$term->id => ['user_score' => 0]], false);
		}


		$response = 'User was saved';
		$statusCode = 201;

		return response($response, $statusCode)->header('Content-Type', 'application/json');


	}
}

<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUserTermHomeTermNeighbour;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use SammyK;
use App\MecanexUser;
use App\Term;
use Illuminate\Support\Facades\Auth;
use App\User;

class FacebookApiController extends ApiGuardController
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
//			return $token;


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

        $existing_mecanex_user = MecanexUser::where('email','=',$facebook_user["email"])->get()->first();
        $existing_user = User::where('email','=',$facebook_user["email"])->get()->first();

		// Create the user if it does not exist or update the existing entry.
		// This will only work if you've added the SyncableGraphNodeTrait to your User model.

        if ($existing_user==null){
            $facebook_user["username"]="fb_".$facebook_user["id"];
        }
        else {
            $facebook_user["username"]=$existing_user->username;
        }

		$user = User::createOrUpdateGraphNode($facebook_user);

//store profile data in mecanex_users table


		$id = $user->id;
		$facebook_id = $user->facebook_user_id;
        if ($existing_mecanex_user==null){
            $username="fb_".$user->facebook_user_id;
        }
        else{
            $username=$existing_mecanex_user->username;
        }
        $email = $user->email;
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
        $fbuser->username=$username;
		$fbuser->user_id = $id;
		$fbuser->facebook_user_id = $facebook_id;
		$fbuser->gender_id = $gender_id;
		$fbuser->name = $name;
		$fbuser->surname = $surname;
        $fbuser->email=$email;
		$fbuser->save();

		// Log the user into Laravel
		Auth::login($user);
		// create records in table users_terms-scores once a mecanex user has been created

        if ($existing_mecanex_user==null)
        {
            $terms = Term::all();
            $total_terms = count($terms);

            foreach ($terms as $term)
            {
                $fbuser->term()->sync([$term->id => ['user_score' => 0]], false);
                $fbuser->profilescore()->sync([$term->id => ['profile_score' => 0]], false);
            }


            for ($i = 1; $i <= $total_terms; $i ++)
            {
                for ($j = $i + 1; $j <= $total_terms; $j ++)
                {
                    $mec_matrix = new MecanexUserTermHomeTermNeighbour();
                    $mec_matrix->mecanex_user_id = $fbuser->id;
                    $mec_matrix->term_home_id = $i;
                    $mec_matrix->term_neighbor_id = $j;
                    $mec_matrix->link_score = 0.05;
                    $mec_matrix->save();
                }

            }
        }


        $response = [
                'username' => $username,
                'message' => 'User was successfully logged in'
        ];
        $statusCode = 201;

		return response($response, $statusCode)->header('Content-Type', 'application/json');


	}
}

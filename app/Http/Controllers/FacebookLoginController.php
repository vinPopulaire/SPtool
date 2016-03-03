<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUser;
use Facebook\Facebook;
use Illuminate\Http\Request;

use SammyK;
//use Facebook\Exceptions\FacebookAuthorizationException;
//use Facebook\Exceptions\FacebookSDKException;
//use Facebook\Exceptions\FacebookResponseException;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Term;
use App\MecanexUserTermHomeTermNeighbour;

class FacebookLoginController extends Controller {


	public function login(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
	{

			$login_link = $fb->getLoginUrl(['email']);

		//return $login_link;

			return view('auth/facebook')->with ('login_link',$login_link);

			//echo '<a href="' . $login_link . '">Log in with Facebook</a>';

		//$fb=new Facebook();
			// Send an array of permissions to request
			//$login_url = $fb->getLoginUrl(['email']);

//		$login_link =$fb->getRedirectLoginHelper()
//			->getLoginUrl('https://localhost/facebook/callback', ['email', 'user_events']);
//
//		echo '<a href="' . $login_link . '">Log in with Facebook</a>';

	}


	public function callback(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
		{

//		$token = $fb->getAccessTokenFromRedirect();
//		dd($token);
			// Obtain an access token.
			try {
				$token = $fb->getAccessTokenFromRedirect();
			} catch (Facebook\Exceptions\FacebookSDKException $e) {
				dd($e->getMessage());
			}

			// Access token will be null if the user denied the request
			// or if someone just hit this URL outside of the OAuth flow.
			if (! $token) {
				// Get the redirect helper
				$helper = $fb->getRedirectLoginHelper();

				if (! $helper->getError()) {
					abort(403, 'Unauthorized action.');
				}

				// User denied the request

//				echo '<p>Error: ' . $helper->getError();
//				echo '<p>Code: ' . $helper->getErrorCode();
//				echo '<p>Reason: ' . $helper->getErrorReason();
//				echo '<p>Description: ' . $helper->getErrorDescription();
//				exit ;

				dd(
					$helper->getError(),
					$helper->getErrorCode(),
					$helper->getErrorReason(),
					$helper->getErrorDescription()
				);
			}

		$fb->setDefaultAccessToken($token);

		if (! $token->isLongLived()) {
			// OAuth 2.0 client handler
			$oauth_client = $fb->getOAuth2Client();

			// Extend the access token.
			try {
				$token = $oauth_client->getLongLivedAccessToken($token);
			} catch (Facebook\Exceptions\FacebookSDKException $e) {
				dd($e->getMessage());
			}
		}

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
		$mecanex_user=$profileresponse->getGraphUser();

        $existing_mecanex_user = MecanexUser::where('facebook_user_id','=',$facebook_user["id"])->get()->first();
        $existing_user = User::where('facebook_user_id','=',$facebook_user["id"])->get()->first();


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

		$id=$user->id;
		$facebook_id=$user->facebook_user_id;
        if ($existing_mecanex_user==null){
            $username="fb_".$user->facebook_user_id;
        }
        else{
            $username=$existing_mecanex_user->username;
        }
        $email=$user->email;
		$fullname=$mecanex_user->getName();
		$fullname=explode(" ", $fullname);
		$name=$fullname[0];
		$surname=$fullname[1];
		$gender=$mecanex_user->getGender();
		if ($gender=='female') {
			$gender_id = 2;
		}
		else {
			$gender_id=1;
		}

		$fbuser=MecanexUser::firstOrNew(array('facebook_user_id'=> $facebook_id));
        $fbuser->username=$username;
		$fbuser->user_id=$id;
		$fbuser->facebook_user_id=$facebook_id;
		$fbuser->gender_id=$gender_id;
		$fbuser->name=$name;
		$fbuser->surname=$surname;
        $fbuser->email=$email;
		$fbuser->save();

		// Log the user into Laravel
		Auth::login($user);

        if ($existing_mecanex_user==null)
        {

            // create records in table users_terms-scores once a mecanex user has been created
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

		return redirect('/home')->with('message', 'Successfully logged in with Facebook');
	}


}

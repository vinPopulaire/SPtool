<?php namespace App\Http\Controllers;

use App\AdvertisementClick;
use App\Enrichment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use App\UserAction;
use App\Http\Requests\SignalsRequest;
use App\Video;
use App\Term;
use App\Action;
use Illuminate\Support\Facades\DB;
use App\MecanexUser;
use App\MecanexUserTermHomeTermNeighbour;
use App\Dcg;
class SignalsApiController extends ApiGuardController
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function signals(SignalsRequest $request)
	{
		$action_type = $request->action;
		$username = $request->username;
		$user = MecanexUser::where('username', $username)->get()->first();

		if (empty($user)) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;
			return response($response, $statusCode )->header('Content-Type', 'application/json');

		} else {

			switch ($action_type) {
				case '1': {   //video play
					return $this->video_function($request);
				}
				case '2': {   //video_stop
					return $this->video_function($request);
				}
				case '3': {  //click on enrichment
					return $this->enrichment_function($request);
				}
				case '4': {    //click on ad
					return $this->ad_function($request);
				}
				case '5': {   //share
					return $this->enrichment_function($request);
				}
				case '6': {   //explicit rf
					return $this->explicitrf_function($request);
				}
				default:
					break;
			}
		}
	}

	public function video_function(SignalsRequest $request)
	{

		$username = $request->username;
		$device = $request->device_id;
		$video_id = $request->video_id;
		$action_type = $request->action;
		$duration=$request->duration;

			switch ($action_type) {

				//case start
				case '1': {
					UserAction::create($request->all());
					return [
                        "message"=>'Video is playing'
					];
				}
//case stop
				case '2' : {

					$video_start = UserAction::where('username', $username)->where('video_id', $video_id)
						->where('device_id', $device)->where('action', 1)->first();
//return $video_start;

					if (empty($video_start)) {
						$response = [
							"error" => "You have to press start first!"
						];
						$statusCode = 404;

					} else {

						UserAction::create($request->all());
						//return 'Video has stopped';
						$video_stop = UserAction::where('username', $username)->where('video_id', $video_id)->where('device_id', $device)->where('action', $action_type)->get();

						//$video = $video->last();
						$stop_time = $request->time;
						$watch_time = $stop_time - ($video_start->time);
						//Have to get the whole video duration--

						//$video_time = $video->video_time;
						$weight = $watch_time /$duration;

						//get importance of action from the respective weight at the actions table
						$get_importance = Action::where('id', $action_type)->first();
						$importance = $get_importance->importance;

						$video_stop = $video_stop->last();
						$video_stop->update(array('weight' => $weight, 'importance' => $importance));

						$statusCode = 200;
						$response = [ "message"=>"$username watched $weight of this video with importance $importance"];
					}
					return response($response, $statusCode)->header('Content-Type', 'application/json');

				}
				default:
					$response = ["error"=>'Action field is required'];
					return response($response, 400)->header('Content-Type', 'application/json');

			}
		}


	public function enrichment_function(SignalsRequest $request)
	{

		$username = $request->username;
		$device = $request->device_id;
		$video_id = $request->video_id;
		$action_type = $request->action;
		//return $action_type;


		switch ($action_type) {

			//case click enrichment
			case '3': {
				$user_action = UserAction::create($request->all());
				$get_importance=Action::where('id',$request->action)->first();
				$importance=$get_importance->importance;
				$user_action->update(array('weight' => 1,'importance' =>$importance));
				$response = ["message"=>'Enrichment Saved'];

				$statusCode = 200;
				return response($response, $statusCode)->header('Content-Type', 'application/json');
			}

			//case share enrichment
			case '5' : {
				$user_action = UserAction::create($request->all());
				$get_importance=Action::where('id',$request->action)->first();
				$importance=$get_importance->importance;
				$user_action->update(array('weight' => 1,'importance' =>$importance));
				$response = ["message"=>'Enrichment shared'];

				$statusCode = 200;
				return response($response, $statusCode)->header('Content-Type', 'application/json');
			}

			default:
				$response = ["message"=>'Action field is required'];
				return response($response, 400)->header('Content-Type', 'application/json');

		}
	}

	public function ad_function(SignalsRequest $request){

		$mecanex_user = MecanexUser::where('username',$request->username)->first();

		$ad_clicks = AdvertisementClick::where('mecanex_user_id',$mecanex_user->id)->where('content_id',$request->content_id)->first();

		if ($ad_clicks == []){
			$ad_click_action=AdvertisementClick::create(array(
				"mecanex_user_id" => $mecanex_user->id,
				"content_id" => $request->content_id,
				"clicks" => 1
			));
		}
		else {
			$num_clicks = $ad_clicks->clicks;
			$ad_clicks->update(array('clicks' => $num_clicks+1));
		}

		$response = ["message"=>'Advertisement Click Saved'];

		$statusCode = 200;
		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}



	public function explicitrf_function(SignalsRequest $request)
	{


		$username = $request->username;
		$device = $request->device_id;
		$video_id = $request->video_id;
		$action_type = $request->action;
		$explicit_rf = $request->value;

		//check if $request->score==-1 or 0 or 1

		$record_exists = UserAction::where('username', $username)->where('video_id', $video_id)->where('action', $action_type)->first();

		if (empty($record_exists)) {

			$user_action = new UserAction(['username'=>$username,'device_id'=>$device,'video_id'=>$video_id,'explicit_rf'=>$explicit_rf,'action'=>$action_type]);
			$user_action->save();
			$get_importance = Action::where('id', $request->action)->first();
			$importance = $get_importance->importance;
			$user_action->update(array('weight' => $explicit_rf, 'importance' => $importance));
		} else {
			$record_exists->update(array('explicit_rf' => $explicit_rf, 'weight' => $explicit_rf));
		}

 //store in the dcgs table - only used for the online experiments
		$mecanex_user=MecanexUser::where('username', $username)->first();
		$dcg_record=Dcg::where('mecanex_user_id',$mecanex_user->id)->where('video_id',$video_id);
		$dcg_record->update(array('explicit_rf'=>$explicit_rf));

//////////////calculate ku///////////////////////

		// number of all enrichments

		$video = Video::where('video_id', $video_id)->first();
		$num_all_enrichments = DB::select(DB::raw('SELECT COUNT(*) as num FROM enrichments_videos_time WHERE video_id=?'), [$video->id]);
		$num_all_enrichments = $num_all_enrichments[0]->num;

		// create list with clicked enrichments

		$get_action_id = Action::where('action','click enrichment')->first();
		$action_id = $get_action_id->id;
		$enrichment_click_ids = UserAction::where('username', $username)->where('video_id', $video_id)->where('action', $action_id)->get(array('content_id'));
		$num_clicked_enrichments = count($enrichment_click_ids);

		// replace all database entries with one with the appropriate weight (so that the calculation can be easily done).
		// The information for what enrichments where clicked is now in the $enrichment_click_ids variable
		if ($num_clicked_enrichments != 0){
			DB::table('user_actions')->where('username',$username)->where('video_id', $video_id)->where('action', $action_id)->delete();
			$user_action = new UserAction(['username'=>$username,'device_id'=>$device,'video_id'=>$video_id,'action'=>$action_id,'content_id'=>'1']);
			$user_action->save();
			$get_importance = Action::where('id', $action_id)->first();
			$importance = $get_importance->importance;
			$user_action->update(array('weight' => $num_clicked_enrichments/$num_all_enrichments, 'importance' => $importance));
		}

		// create list with shared enrichments

		$get_action_id = Action::where('action','share')->first();
		$action_id = $get_action_id->id;
		$enrichment_share_ids = UserAction::where('username', $username)->where('video_id', $video_id)->where('action', $action_id)->get(array('content_id'));
		$num_shared_enrichments = count($enrichment_share_ids);

		// replace all database entries with one with the appropriate weight (so that the calculation can be easily done).
		// The information for what enrichments where clicked is now in the $enrichment_shared_ids variable

		if ($num_shared_enrichments != 0){
			DB::table('user_actions')->where('username',$username)->where('video_id', $video_id)->where('action', $action_id)->delete();
			$user_action = new UserAction(['username'=>$username,'device_id'=>$device,'video_id'=>$video_id,'action'=>$action_id,'content_id'=>'1']);
			$user_action->save();
			$get_importance = Action::where('id', $action_id)->first();
			$importance = $get_importance->importance;
			$user_action->update(array('weight' => $num_shared_enrichments/$num_all_enrichments, 'importance' => $importance));
		}

		$k_nominator = UserAction::where('username', $username)->where('video_id', $video_id)->groupBy('username')
			->get(['username', DB::raw('SUM(importance*weight) as total_score')])->first();

		$query = "SELECT SUM(t1.importance ) AS total FROM (SELECT DISTINCT action, importance FROM user_actions WHERE username=:username AND video_id=:videoid) AS t1 ";
		$k_denominator = DB::select(DB::raw($query), array('username' => $username, 'videoid' => $video_id));  //returns array

		$k = ($k_nominator->total_score) / ($k_denominator[0]->total);  //to [0] gia na prospelasei to 1o stoixeio tou array pou einai to object

/////////////////////////////update weights and update profile//////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////Retrieve Terms/////////////////////////////

//////////////retrieve terms for given video//////////////

		$video = Video::where('video_id', $request->video_id)->first();
		$threshold = 0;    //need to appropriate set
		$results = $video->term()->where('video_score', '>', $threshold)->get(array('term_id'));
		$video_term_list = [];

		foreach ($results as $result) {    //retrieve the terms that will be updated
			array_push($video_term_list, $result->term_id);
		}
		sort($video_term_list);

///////////retrieve terms for the clicked enrichments//////////////
//		$get_actionid = Action::where('action', 'click enrichment')->first();
//		$action_id = $get_actionid->id;
//		$enrichment_ids = UserAction::where('username', $username)->where('video_id', $video_id)->where('action', $action_id)->get(array('content_id'));

		$enrichment_term_list = [];

//		foreach ($enrichment_ids as $enrichment_id)
//		{
//
//			//call the api and get some terms
//			//or emulate enrichment_terms
//			//$results=Enrichment::where('id',$enrichment_id)->get(array('term_id'))
//			foreach($results as $result)
//			{
//				array_push($enrichment_term_list,$result->term_id);
//			}
//
//		}

		//$enrichment_terms=array_unique($enrichment_term_list);
		$enrichment_terms = [3, 4, 7];

		//retrieve terms for the clicked ads

		$ads_terms = [4, 8, 10];

		///Final term_list -  no need since I will update in three steps

//		$term_list=array_merge($video_term_list,$enrichment_terms,$ads_terms);
//		$terms=array_unique($term_list);


////////////////update weights of profile//////////////////////////


		$term_scores = []; //save all scores to get the max

		$user = MecanexUser::where('username', $username)->get()->first();
		$video = Video::where('video_id', $video_id)->get()->first();
		$link_user = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->get()->first();
		//return $video;
		//return $link_user;

		//update based on video_terms
//return $video_term_list;

		foreach ($video_term_list as $video_term_id) {

			$temp_user = $user->term->find($video_term_id);
			$user_term_score = $temp_user->pivot->user_score;  //get score of user

			$temp_video = $video->term->find($video_term_id);
			$video_term_score = $temp_video->pivot->video_score;  //get score of video

			$final_score = $k * (0.8 * $video_term_score);

			foreach ($enrichment_click_ids as $enrichment_click_id) {
				$id = $enrichment_click_id->content_id;

				$enrichment = Enrichment::where('enrichment_id', $id)->get()->first();

				$temp_enrichment = $enrichment->term->find($video_term_id);
				$enrichment_term_score = $temp_enrichment->pivot->enrichment_score;

				$final_score = $final_score + $k * ((0.1/$num_clicked_enrichments) * $enrichment_term_score);
			}

			foreach ($enrichment_share_ids as $enrichment_share_id) {
				$id = $enrichment_share_id->content_id;

				$enrichment = Enrichment::where('enrichment_id', $id)->get()->first();
				$temp_enrichment = $enrichment->term->find($video_term_id);
				$enrichment_term_score = $temp_enrichment->pivot->enrichment_score;

				$final_score = $final_score + $k * ((0.1/$num_shared_enrichments) * $enrichment_term_score);
			}

			//update score
			$new_score = $user_term_score + $final_score;  //ok
            $new_score = max($new_score,0); // don't let negative values
			array_push($term_scores, $new_score);

//				//store score
			$user->term()->sync([$video_term_id => ['user_score' => $new_score]], false);
		}
//return $term_scores;
		// update matrix
		$number_video_terms = count($video_term_list);

		$link_term_scores = []; //save all scores to get the max

		for ($i = 0; $i <= ($number_video_terms - 1); $i++) {
			for ($j = $i + 1; $j < $number_video_terms; $j++) {

				$temp_user_matrix = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->where('term_home_id', $video_term_list[$i])
					->where('term_neighbor_id', $video_term_list[$j])->get()->first();
				//return $temp_user_matrix;
				$temp_video = $video->term->find($video_term_list[$i]);
				$video_term_score1 = $temp_video->pivot->video_score;
				$temp_video = $video->term->find($video_term_list[$j]);
				$video_term_score2 = $temp_video->pivot->video_score;

				$final_score = $k * (0.8 * $video_term_score1 * $video_term_score2);

				foreach ($enrichment_click_ids as $enrichment_click_id) {
					$id = $enrichment_click_id->content_id;

					$enrichment = Enrichment::where('enrichment_id', $id)->get()->first();

					$temp_enrichment = $enrichment->term->find($video_term_list[$i]);
					$enrichment_term_score1 = $temp_enrichment->pivot->enrichment_score;
					$temp_enrichment = $enrichment->term->find($video_term_list[$j]);
					$enrichment_term_score2 = $temp_enrichment->pivot->enrichment_score;

					$final_score = $final_score + $k * ((0.1/$num_clicked_enrichments) * $enrichment_term_score1 * $enrichment_term_score2);
				}

				foreach ($enrichment_share_ids as $enrichment_share_id) {
					$id = $enrichment_share_id->content_id;

					$enrichment = Enrichment::where('enrichment_id', $id)->get()->first();

					$temp_enrichment = $enrichment->term->find($video_term_list[$i]);
					$enrichment_term_score1 = $temp_enrichment->pivot->enrichment_score;
					$temp_enrichment = $enrichment->term->find($video_term_list[$j]);
					$enrichment_term_score2 = $temp_enrichment->pivot->enrichment_score;

					$final_score = $final_score + $k * ((0.1/$num_shared_enrichments) * $enrichment_term_score1 * $enrichment_term_score2);
				}

				$new_score = $temp_user_matrix->link_score + $final_score;
                $new_score = max($new_score,0); // don't let negative values
				array_push($link_term_scores, $new_score);
				$temp_user_matrix->link_score = $new_score;
				$temp_user_matrix->save();
			}
		}


		//same should be done for enrichments and ads


		//find max value and divide term values
		$max_term_value = max(max($term_scores),1);
        if ($link_term_scores!=[])
        {
            $max_link_term_value = max(max($link_term_scores), 1);
        }

		foreach ($video_term_list as $video_term_id) {

			$temp_user = $user->term->find($video_term_id);
			$user_term_score = $temp_user->pivot->user_score;  //get score of user

			$temp_video = $video->term->find($video_term_id);
			$video_term_score = $temp_video->pivot->video_score;  //get score of video

			//update score
			$new_score = $user_term_score / $max_term_value;  //ok

			//store score
			$user->term()->sync([$video_term_id => ['user_score' => $new_score]], false);
		}


		for ($i = 0; $i<= ($number_video_terms - 1); $i++)
		{
			for ($j = $i + 1; $j < $number_video_terms; $j++)
			{
				$temp_user_matrix = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->where('term_home_id', $video_term_list[$i])
				->where('term_neighbor_id', $video_term_list[$j])->get()->first();
				$old_score = $temp_user_matrix->link_score;
				$new_score = $old_score / $max_link_term_value;
				$temp_user_matrix->link_score = $new_score;
				$temp_user_matrix->save();

			}
		}


		//calculate profile
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

		DB::table('user_actions')->where('username',$username)->where('video_id', $video_id)->delete();


		$response=["message"=>'RF Saved'];
		$statusCode=200;


		return response($response, $statusCode)->header('Content-Type', 'application/json');


		}


}



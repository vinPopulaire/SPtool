<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Video;

use Javascript;
use App\UserAction;
use App\Action;
use Illuminate\Support\Facades\Redirect;
use App\MecanexUserTermHomeTermNeighbour;
use App\MecanexUser;
use App\Term;
use App\Dcg;


class VideoController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function show($id)
	{
		//function for presenting the video.

		//return $id;
		$video=Video::where('video_id',$id)->get()->first();
		$title=$video->title;
		$summary=$video->summary;
		$id=$video->video_id;
		Javascript::put([
			'user' => Auth::user()->username,
			'video_id' => $id
		]);

		return view('video.play',compact('title','summary','id'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */



	public function search()
	{


		//video recommendation
//maybe is better to have a middleware applied only to search

		$user = Auth::user()->mecanex_user;
		if (empty ($user)) {
			return Redirect::route('profile.create')->with('message', 'You have to create your profile first');

		} else {
			$user_id = $user->id;

			//only for online experiments
			//calculation of DCG

			$dcg = DB::select(DB::raw('select mecanex_user_id ,SUM((POWER(2,explicit_rf)-1)/log2(rank+1)) as dcg_score from dcgs where mecanex_user_id=?'), [$user_id]);

			if(count($dcg[0]->dcg_score)>0) {

						DB::table('users_dcg')->insert(
				['mecanex_user_id' => $user_id, 'dcg' => $dcg[0]->dcg_score]
			);
				}

			DB::table('dcgs')->where('mecanex_user_id', $user_id)->delete();


		//parameter for the experiment
			$neighs = '3';
			$list_neighs = [];


			//content_based recommendation -- using the view
			$results_content = DB::select(DB::raw('select  video_id, title, similarity, euscreen_id FROM user_item_similarity where user=?  GROUP BY video_id, title ORDER BY similarity DESC LIMIT 10'), [$user_id]);

			//collaborative recommendation
//			//multiplies vector of user i with every one of its neighbors and sorts them in descending order
			$results_neighs = DB::select(DB::raw('select neighbor FROM user_neighbor_similarity where user=(?) ORDER BY similarity DESC LIMIT ?'), [$user_id, $neighs]);


			foreach ($results_neighs as $neigh) {
				array_push($list_neighs, $neigh->neighbor);
			}

			if (count($list_neighs)<3) {
				//content recommendation if no neighbors
				$results_recommendation = $results_content;

			} else {

				$string_neighs = implode(',', $list_neighs);

				$results_recommendation = DB::select(DB::raw(' SELECT a.user,a.video_id,user_item_similarity.title,user_item_similarity.euscreen_id, (0.5*user_item_similarity.similarity+0.5*a.score) as total_score
  											from (SELECT  user_neighbor_similarity.user,user_item_similarity.video_id,
  											SUM(user_neighbor_similarity.similarity+user_item_similarity.similarity) as score
  											FROM user_neighbor_similarity INNER JOIN user_item_similarity on user_neighbor_similarity.neighbor=user_item_similarity.user and user_item_similarity.user IN(' . $string_neighs . ')
  											GROUP BY user_neighbor_similarity.user,user_item_similarity.video_id) as a INNER JOIN user_item_similarity on a.video_id = user_item_similarity.video_id and a.user=user_item_similarity.user where a.user=(?) ORDER BY total_score DESC LIMIT 10'), [$user_id]);

			}
		}

		//used for online experiments - creation of dcg table
		$index=0;

		foreach ($results_recommendation as $result)
		{
			$index++;
			$video_id=$result->euscreen_id;
//			$video_id=$result->video_id;

			$dcg=Dcg::firstOrNew(['mecanex_user_id'=>$user_id,'video_id'=>$video_id]);
			$dcg->rank=$index;
			$dcg->save();

		}

			return view('video.recommendation', compact('results_recommendation'));
	}

	public function rf(Request $request)
	{


		$user = Auth::user();
		$username = $user->username;
		$device = "1";
		$video_id = $request->video_id;
		$action_type = 6;
		$explicit_rf = $request->score;
		//check if $request->score==-1 or 0 or 1

		$record_exists = UserAction::where('username', $username)->where('video_id', $video_id)->where('action', $action_type)->first();

		if (empty($record_exists)) {

			$user_action = new UserAction(['username'=>$username,'device_id'=>'1','video_id'=>$video_id,'explicit_rf'=>$explicit_rf,'action'=>$action_type]);
			$user_action->save();
			$get_importance = Action::where('id', $action_type)->first();
			$importance = $get_importance->importance;
			$user_action->update(array('weight' => $explicit_rf, 'importance' => $importance));
//			return $record_exists;
		} else {
			$record_exists->update(array('explicit_rf' => $explicit_rf, 'weight' => $explicit_rf));
		}

		//store in the dcgs table - only used for the online experiments
		$mecanex_user=MecanexUser::where('username', $username)->first();
		$dcg_record=Dcg::where('mecanex_user_id',$mecanex_user->id)->where('video_id',$video_id);
		$dcg_record->update(array('explicit_rf'=>$explicit_rf));

//////////////calculate ku///////////////////////

		$k_nominator = UserAction::where('username', $username)->where('video_id', $video_id)->groupBy('username')
			->get(['username', DB::raw('SUM(importance*weight) as total_score')])->first();
		//prepei edw na to diairw k me to plithos twn sunolikwn enrichments k ads

		$query = "SELECT SUM(t1.importance ) AS total FROM (SELECT DISTINCT action, importance FROM user_actions WHERE username=:username AND video_id=:videoid) AS t1 ";
		$k_denominator = DB::select(DB::raw($query), array('username' => $username, 'videoid' => $video_id));  //returns array

		$k = ($k_nominator->total_score) / ($k_denominator[0]->total);  //to [0] gia na prospelasei to 1o stoixeio tou array pou einai to object


/////////////////////////////update weights and update profile//////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////Retrieve Terms/////////////////////////////

//////////////retrieve terms for given video//////////////

		$video = Video::where('video_id', $video_id)->first();
		$threshold = 0.1;    //need to appropriate set
		$results = $video->term()->where('video_score', '>', $threshold)->distinct()->get(array('term_id'));
		//$results = $results->unique();
		//return $results;
		$video_term_list = [];

		foreach ($results as $result) {    //retrieve the terms that will be updated
			array_push($video_term_list, $result->term_id);
		}
		sort($video_term_list);
		//return $video_term_list;


///////////retrieve terms for the clicked enrichments//////////////
		$get_actionid = Action::where('action', 'click enrichment')->first();
		$action_id = $get_actionid->id;
		$enrichment_ids = UserAction::where('username', $username)->where('video_id', $video_id)->where('action', $action_id)->get(array('content_id'));

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
//		$enrichment_terms = [3, 4, 7];

		//retrieve terms for the clicked ads

//		$ads_terms = [4, 8, 10];

		///Final term_list -  no need since I will update in three steps

//		$term_list=array_merge($video_term_list,$enrichment_terms,$ads_terms);
//		$terms=array_unique($term_list);


////////////////update weights of profile//////////////////////////


		$term_scores = []; //save all scores to get the max

		$user = MecanexUser::where('username', $username)->get()->first();
		$video = Video::where('video_id', $video_id)->get()->first();
		$link_user = MecanexUserTermHomeTermNeighbour::where('mecanex_user_id', $user->id)->get()->first();

		//return $link_user;

		//update based on video_terms

		foreach ($video_term_list as $video_term_id) {

			$temp_user = $user->term->find($video_term_id);
			$user_term_score = $temp_user->pivot->user_score;  //get score of user

			$temp_video = $video->term->find($video_term_id);
			$video_term_score = $temp_video->pivot->video_score;  //get score of video

			//update score
			$new_score = $user_term_score + $k * (0.8 * $video_term_score);  //ok
            $new_score = max($new_score,0); // don't let negative values
			array_push($term_scores, $new_score);

//				//store score
			$user->term()->sync([$video_term_id => ['user_score' => $new_score]], false);
		}

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
				//return $temp_user_matrix;

				$new_score = $temp_user_matrix->link_score + $k * (0.8 * ($video_term_score1 * $video_term_score2));
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
            $max_link_term_value = max(max($link_term_scores),1);
        }

		foreach ($video_term_list as $video_term_id) {

			$temp_user = $user->term->find($video_term_id);
			$user_term_score = $temp_user->pivot->user_score;  //get score of user

			$temp_video = $video->term->find($video_term_id);
			$video_term_score = $temp_video->pivot->video_score;  //get score of video

			//update score
			$new_score = $user_term_score / $max_term_value;  //ok

//				//store score
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
					$link_score=1;

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

		return Redirect::route('home')->with('message', 'Thank you for watching the video');
	}



}

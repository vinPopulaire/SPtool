<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUser;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;



class SearchApiController extends Controller {
//this controller implements recommendation of videos.
//a similar approach has to be included for the enrichments


	public function search(SearchRequest $request)
	{
		//this assumes that the input is of type videos=EUS_025A722EA4B240D8B6F6330A8783143C,EUS_00A5E7F2D522422BB3BF3BF611CAB22F
		//however according to the input decided proper adjustments have to be made bearing in mind that where in expects string, e.g. 'a',b'
		$username = $request->username;
		$user = MecanexUser::where('username', $username)->get()->first();
		$videos = $request->videos;
		$videos = "'" . str_replace(",", "','", $videos) . "'";


		//check if user exists
		if (empty($user)) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;
		} else {

			$user_id = $user->id;
			//parameter for the experiment
			$neighs = '2';
			$list_neighs = [];


			//content_based recommendation -- using the view
			$results_content = DB::select(DB::raw('select  video_id, title, similarity, euscreen_id FROM user_item_similarity where user=? and  euscreen_id  IN (' . $videos . ')  GROUP BY video_id, title ORDER BY similarity DESC LIMIT 10'), [$user_id]);


			//collaborative recommendation
//			//multiplies vector of user i with every one of its neighbors and sorts them in descending order
			$results_neighs = DB::select(DB::raw('select neighbor FROM user_neighbor_similarity where user=? ORDER BY similarity DESC LIMIT ?'), [$user_id, $neighs]);


			foreach ($results_neighs as $neigh) {
				array_push($list_neighs, $neigh->neighbor);
			}
//


			if (empty($list_neighs)) {
				//content recommendation if no neighbors
				$results_recommendation = $results_content;

			} else {

				$string_neighs = implode(',', $list_neighs);

				$results_recommendation = DB::select(DB::raw(' SELECT a.user,a.video_id,user_item_similarity.title, (0.8*user_item_similarity.similarity+0.2*a.score) as result from (SELECT  user_neighbor_similarity.user,user_item_similarity.video_id, SUM(user_neighbor_similarity.similarity+user_item_similarity.similarity) as score FROM user_neighbor_similarity INNER JOIN user_item_similarity on user_neighbor_similarity.neighbor=user_item_similarity.user and user_item_similarity.user IN(' . $string_neighs . ') GROUP BY user_neighbor_similarity.user,user_item_similarity.video_id) as a INNER JOIN user_item_similarity on a.video_id = user_item_similarity.video_id and a.user=user_item_similarity.user where a.user=? ORDER BY score DESC LIMIT 10'), [$user_id]);
			}


			$final_results=[];
			foreach ($results_recommendation as $result)
			{
				array_push($final_results, $result->euscreen_id);
			}


			$response = [
				"Video Ids" => $final_results
			];
			$statusCode = 200;
		}


		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}


public function recommend($username)

{
	//this assumes that the input is of type videos=EUS_025A722EA4B240D8B6F6330A8783143C,EUS_00A5E7F2D522422BB3BF3BF611CAB22F
	//however according to the input decided proper adjustments have to be made bearing in mind that where in expects string, e.g. 'a',b'


	$user=MecanexUser::where('username', $username)->get()->first();


	if (empty($user)) {

		$response = [
			"error" => "User doesn`t exist"
		];
		$statusCode = 404;
	}
else {

	$user_id = $user->id;
	//parameter for the experiment
	$neighs = '2';
	$list_neighs = [];


	//content_based recommendation -- using the view
	$results_content = DB::select(DB::raw('select  video_id, title, similarity FROM user_item_similarity where user=?  GROUP BY video_id, title ORDER BY similarity DESC LIMIT 10'), [$user_id]);

	//collaborative recommendation
//			//multiplies vector of user i with every one of its neighbors and sorts them in descending order
	$results_neighs = DB::select(DB::raw('select neighbor FROM user_neighbor_similarity where user=? ORDER BY similarity DESC LIMIT ?'), [$user_id, $neighs]);


	foreach ($results_neighs as $neigh) {
		array_push($list_neighs, $neigh->neighbor);
	}

	if (empty($list_neighs)) {
		//content recommendation if no neighbors
		$results_recommendation = $results_content;

	} else {

		$string_neighs = implode(',', $list_neighs);

		$results_recommendation = DB::select(DB::raw(' SELECT a.user,a.video_id,user_item_similarity.title, user_item_similarity.euscreen_id, (0.8*user_item_similarity.similarity+0.2*a.score) as result from (SELECT  user_neighbor_similarity.user,user_item_similarity.video_id, SUM(user_neighbor_similarity.similarity+user_item_similarity.similarity) as score FROM user_neighbor_similarity INNER JOIN user_item_similarity on user_neighbor_similarity.neighbor=user_item_similarity.user and user_item_similarity.user IN(' . $string_neighs . ') GROUP BY user_neighbor_similarity.user,user_item_similarity.video_id) as a INNER JOIN user_item_similarity on a.video_id = user_item_similarity.video_id and a.user=user_item_similarity.user where a.user=? ORDER BY score DESC LIMIT 10'), [$user_id]);

		}
		$final_results=[];
		foreach ($results_recommendation as $result)
		{
			array_push($final_results, $result->euscreen_id);
		}


		$response = [
			"Video Ids" => $final_results
		];
		$statusCode = 200;
	}


	return response($response, $statusCode)->header('Content-Type', 'application/json');
}



}

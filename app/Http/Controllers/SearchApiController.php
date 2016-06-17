<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUser;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Video;
use App\Term;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;



class SearchApiController extends ApiGuardController {
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

        $limit = 10;

		//check if user exists
		if (empty($user)) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;
		} else {

			$user_id = $user->id;
			//parameter for the experiment
			$neighs = '0';
			$list_neighs = [];


			//content_based recommendation -- using the view
            $results_content = $this->content_similarity($user_id, $videos, $limit);

			//collaborative recommendation
//			//multiplies vector of user i with every one of its neighbors and sorts them in descending order
			$results_neighs = DB::select(DB::raw('select neighbor FROM user_neighbor_similarity where user=? ORDER BY similarity DESC LIMIT ?'), [$user_id, $neighs]);


			foreach ($results_neighs as $neigh) {
				array_push($list_neighs, $neigh->neighbor);
			}
//

            if (count($list_neighs)<3) {
				//content recommendation if no neighbors
				$results_recommendation = $results_content;

			} else {

				$string_neighs = implode(',', $list_neighs);

				$results_recommendation = DB::select(DB::raw(' SELECT a.user,a.video_id,user_item_similarity.title, (0.8*user_item_similarity.similarity+0.2*a.score) as total_score
 											from (SELECT  user_neighbor_similarity.user,user_item_similarity.video_id,
 											SUM(user_neighbor_similarity.similarity+user_item_similarity.similarity) as score
 											FROM user_neighbor_similarity INNER JOIN user_item_similarity on user_neighbor_similarity.neighbor=user_item_similarity.user and user_item_similarity.user IN(' . $string_neighs . ')
 											GROUP BY user_neighbor_similarity.user,user_item_similarity.video_id) as a INNER JOIN user_item_similarity on a.video_id = user_item_similarity.video_id and a.user=user_item_similarity.user where a.user=? ORDER BY total_score DESC LIMIT 10'), [$user_id]);
			}


			$final_results=[];
			foreach ($results_recommendation as $result)
			{
				array_push($final_results, $result['video_id']);
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

    $limit = 10;
	$user=MecanexUser::where('username', $username)->get()->first();
    $videos = Video::all();
    $num_of_videos = count($videos);

    $results_content = [];
    $results_collaborative = [];


	if (empty($user)) {

		$response = [
			"error" => "User doesn`t exist"
		];
		$statusCode = 404;
	}
	else {

        $user_id = $user->id;
        //parameter for the experiment
        $neighs = '4';
        $list_neighs = [];

        $video_ids = [];

        //content_based recommendation
        $results_content = $this->content_similarity($user_id,$video_ids);

        //collaborative recommendation
    //			//multiplies vector of user i with every one of its neighbors and sorts them in descending order
//        $results_neighs = DB::select(DB::raw('select neighbor FROM user_neighbor_similarity where user=? ORDER BY similarity DESC LIMIT ?'), [$user_id, $neighs]);

        $results_neighs = $this->similar_neighbors($user_id,$neighs);

        foreach ($results_neighs as $neigh) {
//            array_push($list_neighs, $neigh->neighbor);
            array_push($list_neighs, $neigh);
        }

        $num_of_neighbors = count($list_neighs);

        if ($num_of_neighbors<3) {
            $results_recommendation = $results_content;
        }
        else {
            $results_collaborative = array_fill(1, $num_of_videos, 0);
            foreach ($list_neighs as $neigh) {
                $neighbor_results_content = $this->content_similarity($neigh["neighbor"], $video_ids);

                foreach ($neighbor_results_content as $id=>$result){
                    $results_collaborative[$id] = $results_collaborative[$id] + $result/$num_of_neighbors;
                }
            }

            foreach ($results_content as $id=>$result) {
                $results_recommendation[$id] = 0.8*$results_content[$id]+0.2*$results_collaborative[$id];
            }
        }

        arsort($results_recommendation);
        $results_recommendation = array_slice($results_recommendation, 0, $limit, true);

        $final_results=[];
        foreach ($results_recommendation as $id=>$result){
            $video = Video::where('id',$id)->get()->first();
            array_push($final_results, $video["video_id"]);
        }

//        return $results_recommendation;
//
//        if (count($list_neighs)<3) {
//            //content recommendation if no neighbors
//            $results_recommendation = $results_content;
//
//        } else {
//            $string_neighs = implode(',', $list_neighs);
//
//            $results_recommendation = DB::select(DB::raw(' SELECT a.user,a.video_id,user_item_similarity.title, user_item_similarity.euscreen_id, (0.8*user_item_similarity.similarity+0.2*a.score) as result from (SELECT  user_neighbor_similarity.user,user_item_similarity.video_id, SUM(user_neighbor_similarity.similarity+user_item_similarity.similarity) as score FROM user_neighbor_similarity INNER JOIN user_item_similarity on user_neighbor_similarity.neighbor=user_item_similarity.user and user_item_similarity.user IN(' . $string_neighs . ') GROUP BY user_neighbor_similarity.user,user_item_similarity.video_id) as a INNER JOIN user_item_similarity on a.video_id = user_item_similarity.video_id and a.user=user_item_similarity.user where a.user=? ORDER BY score DESC LIMIT 10'), [$user_id]);
//
//        }
//            $final_results=[];
//            foreach ($results_recommendation as $result)
//            {
//                array_push($final_results, $result['video_id']);
//            }


            $response = [
                "Video Ids" => $final_results
            ];
            $statusCode = 200;
	}


	return response($response, $statusCode)->header('Content-Type', 'application/json');
}

    private function similar_neighbors($user_id,$N) {
        $result = [];
        $temp_profile_scores = [];

        $terms = Term::all();
        $neighbors = MecanexUser::all();
        $user = MecanexUser::where('id', $user_id)->get()->first();
        $user_terms_scores = $user->profilescore;

        foreach ($user_terms_scores as $user_term_score){
            $temp_profile_scores[] = $user_term_score->pivot->profile_score;
        }

        foreach ($neighbors as $neighbor) {
            if ($neighbor->id == $user_id) {
                continue;
            }
            $arithmitis = 0;
            $sumA = 0;
            $sumB = 0;
            $temp_neighbor_scores = [];

            $neighbor_terms_scores = DB::select(DB::raw('SELECT * FROM users_terms_profilescores WHERE mecanex_user_id=? ORDER BY term_id'), [$neighbor->id]);

            foreach ($neighbor_terms_scores as $neighbor_term_score) {
                $temp_neighbor_scores[] = $neighbor_term_score->profile_score;
            }

            for ($i=0;$i<count($terms);$i++)
            {
                $arithmitis = $arithmitis + $temp_neighbor_scores[$i]*$temp_profile_scores[$i];
                $sumA = $sumA + pow($temp_neighbor_scores[$i],2);
                $sumB = $sumB + pow($temp_profile_scores[$i],2);
            }

            $neighborScores[$neighbor->id] = $arithmitis/(sqrt($sumA) + sqrt($sumB));
        }

        arsort($neighborScores);

        $neighborScores = array_slice($neighborScores, 0, $N, true);

        foreach ($neighborScores as $key=>$score){
            $neighbor = $neighbors->find($key);
            $result[] = array(
                'neighbor' => $neighbor->id,
                'similarity' => $score
            );
        }

        return $result;
    }

	private function content_similarity ($user_id,$video_ids) {
		$result = [];
        $temp_profile_scores = [];

        // if there is no video list, search all videos, else only those on the list
        if (count($video_ids)==0)
        {
            $videos = Video::all();
        }
        else {
            $videos = Video::whereRaw('video_id  IN (' . $video_ids . ')')->get();
        }

        //keep all terms of the user in a list
		$terms = Term::all();
		$user = MecanexUser::where('id', $user_id)->get()->first();
		$user_terms_scores = $user->profilescore;

		foreach ($user_terms_scores as $user_term_score){
			$temp_profile_scores[] = $user_term_score->pivot->profile_score;
		}

		foreach ($videos as $video) {
			$arithmitis = 0;
			$sumA = 0;
			$sumB = 0;
			$temp_video_scores=[];

            //keep all terms of video in a list
			$video_terms_scores = DB::select(DB::raw('SELECT * FROM videos_terms_scores WHERE video_id=? ORDER BY term_id'), [$video->id]);

			foreach ($video_terms_scores as $video_term_score){
				$temp_video_scores[] = $video_term_score->video_score;
			}

            // calculate the similarity
			for ($i=0;$i<count($terms);$i++)
			{
				$arithmitis = $arithmitis + $temp_video_scores[$i]*$temp_profile_scores[$i];
				$sumA = $sumA + pow($temp_video_scores[$i],2);
				$sumB = $sumB + pow($temp_profile_scores[$i],2);
			}

			$videoScores[$video->id] = $arithmitis/(sqrt($sumA) + sqrt($sumB));
		}

        return $videoScores;

//		arsort($videoScores);
//        $videoScores = array_slice($videoScores, 0, $limit, true);
//		foreach ($videoScores as $key=>$score){
//            $video = $videos->find($key);
//			$result[] = array(
//				'video_id' => $video->video_id,
//                'id'       => $video->id,
//				'similarity' =>$score
//			);
//		}
//
//		return $result;
	}


}

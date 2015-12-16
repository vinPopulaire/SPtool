<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUser;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class SearchController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function search(SearchRequest $request)
	{
		//
		$username = $request->username;
		$user=MecanexUser::where('username',$username)->get()->first();
		$video_ids=[];
		$test=$request->videos;
		$video_ids=explode(',',$test);
		//return $video_ids;


//check if user exists
		if (empty($user)) {

			$response = [
				"error" => "User doesn`t exist"
			];
			$statusCode = 404;
		}
		else {



				//search operation
//				$video_ids = Video::where('topic', $topic)->get(array('id'))->toArray();
//				$video_ids=array_flatten($video_ids);
//				//dd($video_ids);


//				$video_string= implode(",", $video_ids);  //to impplode twra den paizei


				$user = MecanexUser::where('username', $username)->get(array('id'))->first();
				$user_id = $user->id;

				//$temp_table = DB::select(DB::raw('select  V.video_id, SUM(video_score*user_score) as total_score FROM videos_terms_scores AS V INNER JOIN users_terms_scores as U ON U.profile_term_id=V.profile_term_id where U.mecanex_user_id=(?) and V.video_id IN (?) GROUP BY V.video_id ORDER BY total_score DESC'), [$user_id, $test]);
				//$temp_table = DB::table('videos_terms_scores')->join('users_terms_scores', 'profile_term_id', '=', 'users_terms_scores.profile_term_id')->join('videos_terms_scores', 'profile_term_id', '=', 'videos_terms_scores.profile_term_id')->select('videos_terms_scores.video_id')->get();


//				$results = DB::table('videos_terms_scores')
//					->join('users_terms_scores','videos_terms_scores.term_id','=','users_terms_scores.term_id')
//					->where('users_terms_scores.mecanex_user_id',$user_id)
//					->whereIn('videos_terms_scores.video_id', $video_ids)
//					->orderBy('total_score', 'desc')
//					->groupBy('videos_terms_scores.video_id')
//					->get(['videos_terms_scores.video_id',DB::raw('SUM(video_score*user_score) as total_score' )]);
//				//->get();

			$results = DB::table('videos_terms_scores')
				->join('users_terms_profilescores','videos_terms_scores.term_id','=','users_terms_profilescores.term_id')
				->where('users_terms_profilescores.mecanex_user_id',$user_id)
				->whereIn('videos_terms_scores.video_id', $video_ids)
				->orderBy('total_score', 'desc')
				->groupBy('videos_terms_scores.video_id')
				->get(['videos_terms_scores.video_id',DB::raw('SUM(video_score*profile_score) as total_score' )]);


				$response = [
					"Video Ids" => $results
				];
				$statusCode = 200;
			}


		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */


}

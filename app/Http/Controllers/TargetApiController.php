<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

use App\MecanexUser;
use Illuminate\Http\Request;
use KMeans\Space;

class TargetApiController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function target(Request $request)
	{
		try {

			$mecanexusers = MecanexUser::all();

			// filter by demographics

			if ($request->gender_id != 0) {
				$mecanexusers = $mecanexusers->where("gender_id",(int) $request->gender_id);
			}

			if ($request->age_id != 0) {
				$mecanexusers = $mecanexusers->where("age_id",(int) $request->age_id);
			}

			if ($request->education_id != 0) {
				$mecanexusers = $mecanexusers->where("education_id",(int) $request->education_id);
			}

			if ($request->occupation_id != 0) {
				$mecanexusers = $mecanexusers->where("occupation_id",(int) $request->occupation_id);
			}

			if ($request->country_id != 0) {
				$mecanexusers = $mecanexusers->where("country_id",(int) $request->country_id);
			}

			// filter by preference on terms
			// keep mecanex users whose term profile score is more than 0.7 when normalized by the max term value of the user

			if ($request->terms != []) {

				$all_terms = Term::all();

				foreach ($all_terms as $term) {
					if ((strpos($request->terms,$term->term) !== false)) {
						$mecanexusers = $mecanexusers->filter(function($user) use ($term)
						{
							$myquery = DB::select(DB::raw(' SELECT MAX(profile_score) as mymax
                                                           FROM users_terms_profilescores
                                                           WHERE mecanex_user_id='. $user->id .''));
							if ($myquery[0]->mymax==0) { // don't take into account users that have not provided any information
								return false;
							}
							return $user->profilescore[$term->id-1]['pivot']['profile_score']/$myquery[0]->mymax>0.7; // minus one because terms start from 0 where id starts from 1
						});
//                        $response[] = $mecanexusers[1]->profilescore[$term->id-1]['pivot']['profile_score'];
//                        $myquery = DB::select(DB::raw(' SELECT MAX(profile_score) as mymax
//                                                           FROM users_terms_profilescores
//                                                           WHERE mecanex_user_id='. $mecanexusers[2]->id .''));
					}
				}
			}

			$array_of_users=array();

			// If no mecanexusers exist from the filters selected, we return a random list of videos

			if ($mecanexusers->isEmpty()){

				$response=[];
				$response['message'][] = "No information for the target group";

				$statusCode = 200;
				return $response;
			}

			foreach ($mecanexusers as $mecanexuser) {

				$array=array();

				$terms = $mecanexuser->profilescore;

				foreach ($terms as $term)
				{
					$temp=(float) $term['pivot']['profile_score'];
					array_push($array,$temp);
				}

				// normalize with maximum because that way the clustering seems more accurate
				$maximum = max($array);
				for ($i=0; $i<count($array) ;$i++){
					$array[$i]=$array[$i]/$maximum;
				}

				array_push($array_of_users, $array);

			};

			/** return the array of users so that we can see whether the profiles have normalized
			 * values so that they can be clustered properly
			 */

			$space = new Space(14);
			$num_of_clusters = 5;

			foreach ($array_of_users as $point){
				$space->addPoint($point);
			}

			$clusters = $space->solve($num_of_clusters);

			$all_users = [];

//            foreach ($clusters as $i => $cluster)
//                printf("Cluster %d [%d,%d]: %d points\n", $i, $cluster[0], $cluster[1], count($cluster));

			foreach ($clusters as $i => $cluster) {

				$terms = [];
				for ($j=0;$j<14;$j++){
					array_push($terms, $cluster[$j]);
				}

				$all_users[] = [
					'cluster_id' => $i,
					'cluster_terms' => $terms,
					'num_of_users' => count($cluster),
				];

			}

			$statusCode = 200;

			$response = $all_users;

			return $response;

		} catch (Exception $e) {
			$statusCode = 400;
		} finally {
			return Response::json($response, $statusCode);
		}
	}
}

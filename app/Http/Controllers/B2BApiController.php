<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MecanexUser;

use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use KMeans\Space;

class B2BApiController extends ApiGuardController {

	/**
	 * Return clusterheads and corresponding videos for filtered users.
	 *
	 * @return Clusterheads and videos
	 */
	public function professional(Request $request)
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

            $array_of_users=array();

            foreach ($mecanexusers as $mecanexuser) {

                $array=array();

                $terms = $mecanexuser->profilescore;

                foreach ($terms as $term)
                {
                    $temp=(float) $term['pivot']['profile_score'];
                    array_push($array,$temp);
                }

                array_push($array_of_users, $array);

            };

            /** return the array of users so that we can see whether the profiles have normalized
             * values so that they can be clustered properly
             */
//            return $array_of_users;

            $space = new Space(14);

            foreach ($array_of_users as $point){
                $space->addPoint($point);
            }

            $clusters = $space->solve(5);


            $statusCode = 200;

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

            $video_lists = [];
            foreach ($all_users as $user){
                $video_lists[] = [
                    'cluster_id' => $user['cluster_id'],
                    'video_ids' => $this->recommend_video($user['cluster_terms'],$request),
                    'cluster_terms' => $user['cluster_terms'],
                    'num_of_users' => $user['num_of_users']
                ];
            };

            $response = $video_lists;

        } catch (Exception $e) {
            $statusCode = 400;
        }  finally {
            return Response::json($response, $statusCode);
        }
	}

    private function recommend_video($profile,$request) {

        if ($request->num != 0) {
            $num = $request->num;
        }
        else {
            $num = 50;
        }

        $done = DB::table('temp_profilescores')->get();

        if (empty($done)) {
            $id = 1;
        }
        else {
            $last = end($done);
            $id = $last->id+1;
        }

        for ($i=0;$i<count($profile);$i++) {

            DB::table('temp_profilescores')->insert(
                ['id' => $id,'term_id' => $i+1,'profile_score'=>$profile[$i]]
            );

        }

        if ($request->videos==null){
//        $done = DB::table('temp_profilescores')->get();
//        $last = end($done);

            $top_videos = DB::select(DB::raw('SELECT videos.video_id, SUM(videos_terms_scores.video_score*temp_profilescores.profile_score) AS similarity
                                          FROM videos_terms_scores JOIN temp_profilescores on videos_terms_scores.term_id=temp_profilescores.term_id JOIN videos on videos.id=videos_terms_scores.video_id
                                          GROUP BY videos_terms_scores.video_id
                                          ORDER BY similarity DESC LIMIT ' . $num . ''));
        }
        else {
            //this assumes that the input is of type videos=EUS_025A722EA4B240D8B6F6330A8783143C,EUS_00A5E7F2D522422BB3BF3BF611CAB22F
            $videos = $request->videos;
            $videos = "'" . str_replace(",", "','", $videos) . "'";

            $top_videos = DB::select(DB::raw('SELECT videos.video_id, SUM(videos_terms_scores.video_score*temp_profilescores.profile_score) AS similarity
                                          FROM videos_terms_scores JOIN temp_profilescores on videos_terms_scores.term_id=temp_profilescores.term_id JOIN videos on videos.id=videos_terms_scores.video_id
                                          WHERE videos.video_id  IN (' . $videos . ')
                                          GROUP BY videos_terms_scores.video_id
                                          ORDER BY similarity DESC LIMIT ' . $num . ''));
        }

        DB::table('temp_profilescores')->where('id', '=', $id)->delete();

        return $top_videos;
    }

}

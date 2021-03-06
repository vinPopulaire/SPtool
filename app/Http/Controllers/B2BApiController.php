<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MecanexUser;

use App\Term;
use App\Video;
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

            if ($request->num != 0) {
                $num = $request->num;
            }
            else {
                $num = 50;
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
                if ($request->videos==null) {
                    $videos = Video::orderByRaw('RAND()')->take($num)->get();
                }
                else {
                    $reqvideos = "'" . str_replace(",", "','", $request->videos) . "'";
//                    $videos = Video::where('video_id','in',['EUS_025A722EA4B240D8B6F6330A8783143C'])->orderByRaw('RAND()')->take($num)->get();
                    $videos = DB::select(DB::raw(' SELECT *
                                            FROM videos
                                            WHERE video_id IN (' . $reqvideos . ') ORDER BY RAND()  LIMIT ' . $num . ''));
                }

                $response=[];
                foreach ($videos as $video) {
                    $response['videos'][] = $video->video_id;
                }

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

                array_push($array_of_users, $array);

            };

            /** return the array of users so that we can see whether the profiles have normalized
             * values so that they can be clustered properly
             */
//            return $array_of_users;

            $space = new Space(14);
            $num_of_clusters = 5;

            foreach ($array_of_users as $point){
                $space->addPoint($point);
            }

            $clusters = $space->solve($num_of_clusters);

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

            $cluster_list = [];
            foreach ($all_users as $user){
                $cluster_list[] = [
                    'cluster_id' => $user['cluster_id'],
                    'video_ids' => $this->recommend_video($user['cluster_terms'],$request),
                    'cluster_terms' => $user['cluster_terms'],
                    'num_of_users' => $user['num_of_users']
                ];
            };

//            $response = $cluster_list[0]['video_ids'][0]->id;

            $video_list=[];
            $response = [];
            $num_of_videos = 0;
            $total_num_of_videos = count($cluster_list[0]['video_ids']);



            for ($i=0;$i<$total_num_of_videos;$i++){
                for ($j=0;$j<$num_of_clusters;$j++){
                    $video = $cluster_list[$j]['video_ids'][$i];
                    if (! in_array($video->video_id,$video_list,true)){
                        $video_list[] = $video->video_id;
                        $response['videos'][] = $video->euscreen_id;
                        $num_of_videos += 1;
                    }
                    if ($num_of_videos==$total_num_of_videos){
                        break;
                    }
                }
                if ($num_of_videos==$total_num_of_videos){
                    break;
                }
            }

            return $response;

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

        $neighs = '2';
        $list_neighs = [];

        $results_neighs = DB::select(DB::raw('select neighbor FROM temp_user_neighbor_similarity where user=? ORDER BY similarity DESC LIMIT ?'), [$id, $neighs]);

        foreach ($results_neighs as $neigh) {
            array_push($list_neighs, $neigh->neighbor);
        }

        if ($request->videos==null){
//        $done = DB::table('temp_profilescores')->get();
//        $last = end($done);

            if (empty($list_neighs)) {
                //content recommendation if no neighbors
                $top_videos = DB::select(DB::raw('select  video_id, title, similarity FROM temp_user_item_similarity where user=?  GROUP BY video_id, title ORDER BY similarity DESC LIMIT ' . $num . ''), [$id]);


            } else {

                $string_neighs = implode(',', $list_neighs);

                $top_videos = DB::select(DB::raw(' SELECT a.video_id,temp_user_item_similarity.title, temp_user_item_similarity.euscreen_id, (0.8*temp_user_item_similarity.similarity+0.2*a.score) as total_score
 											from (SELECT  temp_user_neighbor_similarity.user,temp_user_item_similarity.video_id,
 											SUM(temp_user_neighbor_similarity.similarity+temp_user_item_similarity.similarity) as score
 											FROM temp_user_neighbor_similarity INNER JOIN temp_user_item_similarity on temp_user_neighbor_similarity.user=temp_user_item_similarity.user and temp_user_neighbor_similarity.neighbor IN(' . $string_neighs . ')
 											GROUP BY temp_user_neighbor_similarity.user,temp_user_item_similarity.video_id)
 											as a INNER JOIN temp_user_item_similarity on a.video_id = temp_user_item_similarity.video_id and a.user=temp_user_item_similarity.user where a.user=? ORDER BY total_score DESC LIMIT ' . $num . ''), [$id]);
            }
        }
        else {
            //this assumes that the input is of type videos=EUS_025A722EA4B240D8B6F6330A8783143C,EUS_00A5E7F2D522422BB3BF3BF611CAB22F
            $videos = $request->videos;
            $videos = "'" . str_replace(",", "','", $videos) . "'";

            if (empty($list_neighs)) {
                //content recommendation if no neighbors
                $top_videos = DB::select(DB::raw('select  video_id, title, similarity, euscreen_id FROM temp_user_item_similarity where user=? and  euscreen_id  IN (' . $videos . ')  GROUP BY video_id, title ORDER BY similarity DESC LIMIT ' . $num . ''), [$id]);


            } else {

                $string_neighs = implode(',', $list_neighs);

                $top_videos = DB::select(DB::raw(' SELECT a.video_id,temp_user_item_similarity.title, temp_user_item_similarity.euscreen_id, (0.8*temp_user_item_similarity.similarity+0.2*a.score) as result
                                            from (SELECT  temp_user_neighbor_similarity.user,temp_user_item_similarity.video_id,
                                            SUM(temp_user_neighbor_similarity.similarity+temp_user_item_similarity.similarity) as score
                                            FROM temp_user_neighbor_similarity INNER JOIN temp_user_item_similarity on temp_user_neighbor_similarity.user=temp_user_item_similarity.user and temp_user_neighbor_similarity.neighbor IN(' . $string_neighs . ')
                                            GROUP BY temp_user_neighbor_similarity.user,temp_user_item_similarity.video_id)
                                            as a INNER JOIN temp_user_item_similarity on a.video_id = temp_user_item_similarity.video_id and a.user=temp_user_item_similarity.user
                                            where a.user=? and temp_user_item_similarity.euscreen_id IN (' . $videos . ') ORDER BY score DESC LIMIT ' . $num . ''), [$id]);
            }
        }

        DB::table('temp_profilescores')->where('id', '=', $id)->delete();

        return $top_videos;
    }

}

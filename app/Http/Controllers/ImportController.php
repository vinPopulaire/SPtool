<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use App\Video;
use Illuminate\Support\Facades\DB;
use App\Term;
class ImportController extends ApiGuardController
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function scores()
	{

		//indexing of video terms
		set_time_limit(0);
		DB::table('videos_terms_scores')->delete();

//		$counts=DB::select('select count(video_id) from videos');  //take number of videos
//		dd($counts);

		$terms = Term::all();   //take all Profile terms
		$videos=Video::all();

		foreach ($videos as $video) {
			$id = $video->id;

			foreach ($terms as $term) {

				$results = DB::select(DB::raw('select MATCH (topic, thesaurus_terms, summary) AGAINST (? WITH QUERY EXPANSION)  as rev from videos where id = (?)'), [$term->term,$id]);

//				echo 'video_id='.$id.'  term = '.$term->term.'   score = '.$results[0]->rev.'<br>';
				DB::table('videos_terms_scores')->insert(
					['video_id' =>$id, 'term_id' => $term->id,'video_score' =>$results[0]->rev]
				);
//				echo 'record inserted!'.'<br>';

			}
		}



///////////////////normalization///////////////////////////////////////////////////

		//this takes for ever....raw db instead
//				foreach ($videos as $video) {
//				$id = $video->id;
//				$max_score = DB::table('videos_terms_scores')->where('video_id',$id)->max('video_score');
//					foreach ($terms as $term) {
//						$temp_video = $video->term->find($term);
//						$video_term_score = $temp_video->pivot->video_score;  //get score of video
//						$new_score=$video_term_score/$max_score;
//						$video->term()->sync([$term->id=> ['video_score' => $new_score]], false);
//
//					}
//				}

		$query=DB::select(DB::raw('UPDATE videos_terms_scores as t join (select video_id,MAX(video_score) as maximum FROM videos_terms_scores GROUP BY video_id)as max_scores  on  t.video_id=max_scores.video_id  SET t.video_score=t.video_score/max_scores.maximum'));

        $terms = Term::all();   //take all Profile terms
        $videos=Video::all();

        foreach ($videos as $video) {
            $id = $video->id;

            foreach ($terms as $term) {

                $results = DB::select(DB::raw('select COUNT(*) as rev from videos where id='.$id.' and topic LIKE "%'. $term->term .'%"'));

                DB::table('videos_terms_scores')->where('video_id', $id)->where('term_id',$term->id)->update(['video_score' => DB::raw('video_score*0.5+'.$results[0]->rev*0.5.'')]);

            }
        }

//return view ('video.parser');
	}

	public function remove_duplicates_on_score(){
		$terms = Term::all();   //take all Profile terms
		$videos=Video::all();

		foreach ($videos as $video) {

			$id = $video->id;

			foreach ($terms as $term)
			{
				$results = DB::select(DB::raw('select * from videos_terms_scores where video_id=? and term_id=?'), [$id,$term->id]);

				if (count($results)>1)
				{
					DB::table('videos_terms_scores')->where('video_id', $id)->where('term_id',$term->id)->delete();
					DB::table('videos_terms_scores')->insert(
						['video_id' =>$results[0]->video_id, 'term_id' => $results[0]->term_id,'video_score' =>$results[0]->video_score]
					);
				}

			}


		}


		return "removed duplicates";
	}



	public function import()
	{
		set_time_limit(0);
		DB::table('videos')->delete();
		//
		//if (file_exists('video1.xml')) {
			$uri='http://a1.noterik.com:8081/smithers2/domain/espace/user/luce/video';
		//dd($uri);

			$content = utf8_encode(file_get_contents($uri));
			$xml = simplexml_load_string($content);
		//print_r($xml);



			foreach ($xml->video as $video)
			{
				//echo '--video_id='.$xml->video['id'].PHP_EOL;

				//echo '--genre='.$video->properties->genre.PHP_EOL;

				$video_item=new Video();
				$video_item->video_id=$video['id'];
				$video_item->genre=$video->properties->genre;
				$video_item->topic=$video->properties->topic;
				$video_item->title=$video->properties->TitleSet_TitleSetInEnglish_title;
   				$video_item->geographical_coverage=$video->properties->SpatioTemporalInformation_SpatialInformation_GeographicalCoverage;
				$video_item->summary=$video->properties->summaryInEnglish;
				$video_item->thesaurus_terms=$video->properties->ThesaurusTerm;
				$video_item->save();
			}
//
		return view ('video.parser');
	}
//else {
//			exit('Failed to open file.');
//		}
//	}


}
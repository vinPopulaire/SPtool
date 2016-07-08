<?php namespace App\Http\Controllers;

use App\Enrichment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Term;
use App\Video;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ImportApiController extends ApiGuardController {

	/**
	 * Import videos to database and score them.
	 *
	 * @return Response
	 */
	public function import(Request $request)
	{
        set_time_limit(0);

		$uri = $request->uri;

		$content = utf8_encode(file_get_contents($uri));
		$xml = simplexml_load_string($content);

		foreach ($xml->video as $video)
        {
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

        $terms = Term::all();   //take all Profile terms
        $videos=Video::all();

        foreach ($videos as $video) {
            $id = $video->id;

            foreach ($terms as $term) {

                $results = DB::select(DB::raw('select MATCH (genre, topic, geographical_coverage, thesaurus_terms, title) AGAINST (? WITH QUERY EXPANSION)  as rev from videos where id = (?)'), [$term->term,$id]);

                DB::table('videos_terms_scores')->insert(
                    ['video_id' =>$id, 'term_id' => $term->id,'video_score' =>$results[0]->rev]
                );

            }
        }

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

        $response = [
            'message' => 'Successful import'
        ];
        $statusCode = 200;

        return Response::json($response, $statusCode);
	}

    public function importEnrichments(Request $request) {
        set_time_limit(0);

        DB::table('enrichments')->delete();

        $uri = $request->uri;

        $content = utf8_encode(file_get_contents($uri));

        $json = json_decode($content);

//        return $content;

        foreach ($json as $key=>$enrichment) {

            $enrichment_item = new Enrichment();

            $enrichment_item->enrichment_id=$key;
            $enrichment_item->class="unknown";
            $enrichment_item->longName=$enrichment->longName;
            if (isset($enrichment->dbpediaUrl)){
                $enrichment_item->dbpediaURL=$enrichment->dbpediaUrl;
            }
            else {
                $enrichment_item->dbpediaURL="";
            }
            if (isset($enrichment->wikipediaUrl)){
                $enrichment_item->wikipediaURL=$enrichment->wikipediaUrl;
            }
            else {
                $enrichment_item->wikipediaURL="";
            }
            $enrichment_item->description=$enrichment->description;
            $enrichment_item->thumbnail=$enrichment->thumbnail;
            $enrichment_item->save();
        }


        $response = [
            'message' => 'Successful import of enrichments'
        ];
        $statusCode = 200;

        return Response::json($response, $statusCode);
    }

}

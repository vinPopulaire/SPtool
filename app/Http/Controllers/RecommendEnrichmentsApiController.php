<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Video;
use App\Term;
use App\MecanexUser;
use Illuminate\Support\Facades\DB;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;

class RecommendEnrichmentsApiController extends ApiGuardController {

	public function recommendEnrichment(Request $request)
	{
		$video_id = $request->video_id;
		$user_id = $request->user_id;
		$recommendedEnrichments = [];

		$listEnrichments = DB::select(DB::raw('SELECT * FROM enrichments_videos_time WHERE video_id=?'), [$video_id]);
		$listEnrichments = json_decode(json_encode($listEnrichments), true);

		usort($listEnrichments, $this->make_comparer('time'));

		while ($listEnrichments!=[]){
			reset($listEnrichments);
			$i = key($listEnrichments);
			$simultaneous_enrichments = [$listEnrichments[$i]];

			next($listEnrichments);
			$next = key($listEnrichments);

			while (array_key_exists($next, $listEnrichments) and $listEnrichments[$next]["time"] == $listEnrichments[$i]["time"]){
				$simultaneous_enrichments[] = $listEnrichments[$next];
				unset($listEnrichments[$next]);
				next($listEnrichments);
				$next = key($listEnrichments);
			}

			while ($simultaneous_enrichments!=[]){
				reset($simultaneous_enrichments);
				$j = key($simultaneous_enrichments);

				$tmp_enrichments = [];
				$first_enrichment = $simultaneous_enrichments[$j];
				foreach ($simultaneous_enrichments as $id=>$enrichment) {
					if ($first_enrichment["height"] == $enrichment["height"] and $first_enrichment["width"] == $enrichment["width"] and $first_enrichment["x_min"] == $enrichment["x_min"] and $first_enrichment["y_min"] == $enrichment["y_min"]) {
						$tmp_enrichments[] = $enrichment;
						unset($simultaneous_enrichments[$id]);
					}
				}

				$recommendedEnrichments[] = array(
					'enrichment_id' => $this->recommend_enr($tmp_enrichments, $user_id),
					'video_id' => $video_id,
					'time' => $listEnrichments[$i]["time"],
					'height' => $first_enrichment["height"],
					'width' => $first_enrichment["width"],
					'x_min' => $first_enrichment["x_min"],
					'y_min' => $first_enrichment["y_min"],
				);

			}

			unset($listEnrichments[$i]);
		}

//		$recommendedEnrichments[] = $this->recommend_enr($listEnrichments, $user_id);

		return $recommendedEnrichments;
	}

	// Returns one enrichment from the list - the most recommended
	private function recommend_enr($list, $user_id) {

		$terms = Term::all();

		$user = MecanexUser::where('id', $user_id)->get()->first();
		$user_terms_scores = $user->profilescore;

		foreach ($user_terms_scores as $user_term_score) {
			$temp_profile_scores[] = $user_term_score->pivot->profile_score;
		}

		foreach ($list as $enrichment) {
			$arithmitis = 0;
			$sumA = 0;
			$sumB = 0;
			$temp_enrichment_scores = [];

			$enrichment_terms_scores = DB::select(DB::raw('SELECT * FROM enrichments_terms_scores WHERE enrichment_id=? ORDER BY term_id'), [$enrichment["enrichment_id"]]);

			foreach ($enrichment_terms_scores as $enrichment_term_score){
				$temp_enrichment_scores[] = $enrichment_term_score->enrichment_score;
			}

			for ($i=0; $i<count($terms); $i++){
				$arithmitis = $arithmitis + $temp_enrichment_scores[$i]*$temp_profile_scores[$i];
				$sumA = $sumA + pow($temp_enrichment_scores[$i], 2);
				$sumB = $sumB + pow($temp_profile_scores[$i], 2);
			}
			
			$enrichment["score"] = $arithmitis/(sqrt($sumA) + sqrt($sumB));

			$enrichmentScores[$enrichment["enrichment_id"]] = $arithmitis/(sqrt($sumA) + sqrt($sumB));
		}

		arsort($enrichmentScores);

		// first key of enrichmentScores list - the most recommended enrichment
		$recommended_enrichment = key($enrichmentScores);

		return $recommended_enrichment;

	}

	private function make_comparer() {
		// Normalize criteria up front so that the comparer finds everything tidy
		$criteria = func_get_args();
		foreach ($criteria as $index => $criterion) {
			$criteria[$index] = is_array($criterion)
				? array_pad($criterion, 3, null)
				: array($criterion, SORT_ASC, null);
		}

		return function($first, $second) use ($criteria) {
			foreach ($criteria as $criterion) {
				// How will we compare this round?
				list($column, $sortOrder, $projection) = $criterion;
				$sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

				// If a projection was defined project the values now
				if ($projection) {
					$lhs = call_user_func($projection, $first[$column]);
					$rhs = call_user_func($projection, $second[$column]);
				}
				else {
					$lhs = $first[$column];
					$rhs = $second[$column];
				}

				// Do the actual comparison; do not return if equal
				if ($lhs < $rhs) {
					return -1 * $sortOrder;
				}
				else if ($lhs > $rhs) {
					return 1 * $sortOrder;
				}
			}

			return 0; // tiebreakers exhausted, so $first == $second
		};
	}

}

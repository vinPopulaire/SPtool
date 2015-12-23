<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Term;
use App\Interest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Opinion;


class ExperimentController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function checkprofile()
	{
		$mecanex_user= Auth::user()->mecanex_user;
		$terms=Term::all();
		$interests=Interest::all();
		$listterms=[];
		$listscores=[];

		foreach ($interests as $interest)
		{

			array_push($listterms,$interest->interest);
		}
		foreach ($terms as $term)
		{

			$temp_user = $mecanex_user->profilescore->find($term->id);
			$user_term_score = $temp_user->pivot->profile_score;
			array_push($listscores,$user_term_score);
		}
		$userprofile=array_combine($listterms,$listscores);


		return view('user.checkprofile',compact('userprofile'));


	}

	public function agree()

	{
		$mecanex_user=Auth::user()->mecanex_user;
		$mecanex_user_id=$mecanex_user->id;
		$opinion=Opinion::firstOrNew(['mecanex_user_id'=>$mecanex_user_id]);
		$opinion->opinion=1;
		$iteration=($opinion->iteration)+1;
		$opinion->iteration=$iteration;
		$opinion->save();

		return Redirect::route ('home')->with ('message','Thank you for your participation');

	}

	public function disagree()

	{
		$mecanex_user=Auth::user()->mecanex_user;
		$mecanex_user_id=$mecanex_user->id;
		$opinion=Opinion::firstOrNew(['mecanex_user_id'=>$mecanex_user_id]);
		$opinion->opinion=0;
		$iteration=($opinion->iteration)+1;
		$opinion->iteration=$iteration;
		$opinion->save();
		return Redirect::route ('home')->with ('message','Thank you for your participation-dis');

	}
}
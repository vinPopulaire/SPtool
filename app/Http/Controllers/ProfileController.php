<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUser;
use App\Term;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\User;
use App\Gender;
use App\Profile;
use App\Age;
use App\Country;
use App\Occupation;
use App\Education;
use App\Interest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CreateProfileRequest;
use App\MecanexUserTermHomeTermNeighbour;


class ProfileController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('hasProfile',['only' => 'show']);
		$this->middleware('createProfile',['only' => 'create']);
	}


	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$gender=Gender::lists('gender','id');
		$age=Age::lists('age','id');
		$occupation=Occupation::lists('occupation','id');
		$country=Country::orderBy('country')->lists('country', 'id'); //for alphabetic order
		$education=Education::lists('education','id');


		return view ('user.create',compact('gender','age','occupation','country','education'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateProfileRequest $request)
	{

		//validation first
		$request->all();

		$username=Auth::user()->username;
		$name=Input::get('name');
		$surname=Input::get('surname');
		$gender_id=Input::get('gender_id');
		$age_id=Input::get('age_id');
		$country_id=Input::get('country_id');
		$occupation_id=Input::get('occupation_id');
		$education_id=Input::get('education_id');
		//$facebook=Input::get('facebook');
		//$twitter=Input::get('twitter');
		$mecanex_user=new MecanexUser(['username'=>$username,'name'=>$name, 'surname'=>$surname,'gender_id'=> $gender_id,'age_id'=> $age_id, 'education_id'=> $education_id, 'occupation_id'=> $occupation_id,'country_id'=> $country_id]);

		$user=User::find(Auth::user()->id);
		$mecanex_user=$user->profile()->save($mecanex_user);
		//$mecanex_user->save();

		// create records in table users_terms-scores once a mecanex user has been created
		$terms=Term::all();
		$total_terms=$terms->count();

		foreach ($terms as $term)
		{

			$mecanex_user->term()->sync([$term->id=>['user_score'=>0]],false);
			$mecanex_user->profilescore()->sync([$term->id=>['profile_score'=>0]],false);

		}


		//create record in table mecanex_user_term_home_term_neighbor once a mecanex user has been created

		for ($i=1;$i<=$total_terms; $i++)
			{
			for ($j=$i+1;$j<=$total_terms; $j++)
				{
					$mec_matrix=new MecanexUserTermHomeTermNeighbour();
					$mec_matrix->mecanex_user_id=$mecanex_user->id;
					$mec_matrix->term_home_id=$i;
					$mec_matrix->term_neighbor_id=$j;
					$mec_matrix->link_score=0.5;
					$mec_matrix->save();
				}

			}


		return view ('user.profile')->with ('message','You can now state your interests');
		//
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{


		return view('user.profile')->with ('message','You can now state your interests');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		//
		$gender=Gender::lists('gender','id');
		$age=Age::lists('age','id');
		$occupation=Occupation::lists('occupation','id');
		$country=Country::orderBy('country')->lists('country', 'id'); //for alphabetic order
		$education=Education::lists('education','id');
		//return Auth::User()->profile;
		return view ('user.edit',compact('gender','age','occupation','country','education'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateProfileRequest $request)
	{

		//validation first
		$request->all();

		$profile=Auth::user()->mecanex_user;
		$profile->name=Input::get('name');
		$profile->surname=Input::get('surname');
		$profile->gender_id=Input::get('gender_id');
		$profile->age_id=Input::get('age_id');
		$profile->occupation_id=Input::get('occupation_id');
		$profile->country_id=Input::get('country_id');
		$profile->education_id=Input::get('education_id');
		//$profile->facebook_account=Input::get('facebook_account');
		//$profile->twitter_account=Input::get('twitter_account');
		$profile->save();

		return Redirect::route('profile.update')->with('message', 'Your profile has been updated');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		//

		$profile=Auth::user()->mecanex_user;
		$profile->delete();
		return Redirect::route('home')->with('message', 'Your profile has been deleted');

	}

}

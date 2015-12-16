<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MecanexUser;
use App\Term;
use Illuminate\Http\Request;
use App\Interest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class InterestController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
		//$this->middleware('createInterest',['only' => 'create']);
		$this->middleware('hasInterest',['only' => 'create']);

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
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


		return view ('user.interest.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{


		$mecanex_user= Auth::user()->mecanex_user;
		//get the input
		$arts = $request->arts;
		$disasters = $request->disasters;
		$education = $request->education;
		$environment = $request->environment;
		$health = $request->health;
		$lifestyle = $request->lifestyle;
		$media= $request->media;
		$holidays= $request->holidays;
		$politics= $request->politics;
		$religion= $request->religion;
		$society= $request->society;
		$transportation= $request->transportation;
		$wars= $request->wars;
		$work= $request->work;

		//store input in pivot table
//
//		$mecanex_user->interest()->sync(1,array('interest_score'=>$arts));
//		$mecanex_user->interest()->sync(2,array('interest_score'=>$disasters));
//		$mecanex_user->interest()->sync(3,array('interest_score'=>$education));
//		$mecanex_user->interest()->sync(4,array('interest_score'=>$environment));
//		$mecanex_user->interest()->sync(5,array('interest_score'=>$health));
//		$mecanex_user->interest()->sync(6,array('interest_score'=>$lifestyle));
//		$mecanex_user->interest()->sync(7,array('interest_score'=>$media));
//		$mecanex_user->interest()->sync(8,array('interest_score'=>$holidays));
//		$mecanex_user->interest()->sync(9,array('interest_score'=>$politics));
//		$mecanex_user->interest()->sync(10,array('interest_score'=>$religion));
//		$mecanex_user->interest()->sync(11,array('interest_score'=>$society));
//		$mecanex_user->interest()->sync(12,array('interest_score'=>$transportation));
//		$mecanex_user->interest()->sync(13,array('interest_score'=>$wars));
//		$mecanex_user->interest()->sync(14,array('interest_score'=>$work));

		$mecanex_user->interest()->sync([1=>['interest_score'=>$arts],2=>['interest_score'=>$disasters],3=>['interest_score'=>$education],4=>['interest_score'=>$environment],5=>['interest_score'=>$health],6=>['interest_score'=>$lifestyle],7=>['interest_score'=>$media], 8=>['interest_score'=>$holidays],9=>['interest_score'=>$politics],10=>['interest_score'=>$religion],11=>['interest_score'=>$society],12=>['interest_score'=>$transportation],13=>['interest_score'=>$wars],14=>['interest_score'=>$work]]);

		//initialize user profile - update table users_terms_scores

		//for every interest sort_name find the id of the profile terms
		$interests=Interest::all(array('short_name'));
		$user_interests=$mecanex_user->interest;

		foreach ($user_interests as $user_interest)
		{
			$short_name= $user_interest->short_name;
			$term=Term::where('term',$short_name)->firstOrFail();

			$mecanex_user->term()->sync([$term->id=>['user_score'=>$user_interest->pivot->interest_score/5]],false);  //normalization
			$mecanex_user->profilescore()->sync([$term->id=>['profile_score'=>$user_interest->pivot->interest_score/5]],false);

		}
		return Redirect::route('interest.edit');
	}



	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{



	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		$mecanex_user= Auth::user()->mecanex_user;

		$arts = $mecanex_user->interest()->wherePivot('interest_id','=',1)->first()->pivot->interest_score;
		$disasters = $mecanex_user->interest()->wherePivot('interest_id','=',2)->first()->pivot->interest_score;
		$education = $mecanex_user->interest()->wherePivot('interest_id','=',3)->first()->pivot->interest_score;
		$environment = $mecanex_user->interest()->wherePivot('interest_id','=',4)->first()->pivot->interest_score;
		$health = $mecanex_user->interest()->wherePivot('interest_id','=',5)->first()->pivot->interest_score;
		$lifestyle = $mecanex_user->interest()->wherePivot('interest_id','=',6)->first()->pivot->interest_score;
		$media = $mecanex_user->interest()->wherePivot('interest_id','=',7)->first()->pivot->interest_score;
		$holidays = $mecanex_user->interest()->wherePivot('interest_id','=',8)->first()->pivot->interest_score;
		$politics = $mecanex_user->interest()->wherePivot('interest_id','=',9)->first()->pivot->interest_score;
		$religion= $mecanex_user->interest()->wherePivot('interest_id','=',10)->first()->pivot->interest_score;
		$society = $mecanex_user->interest()->wherePivot('interest_id','=',11)->first()->pivot->interest_score;
		$transportation = $mecanex_user->interest()->wherePivot('interest_id','=',12)->first()->pivot->interest_score;
		$wars = $mecanex_user->interest()->wherePivot('interest_id','=',13)->first()->pivot->interest_score;
		$work = $mecanex_user->interest()->wherePivot('interest_id','=',14)->first()->pivot->interest_score;





	return view ('user.interest.edit',compact('arts','disasters','education','environment','health','lifestyle','media','holidays','politics','religion','society','transportation','wars','work'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		//
		//get the input
		$arts = $request->arts;
		$disasters = $request->disasters;
		$education = $request->education;
		$environment = $request->environment;
		$health = $request->health;
		$lifestyle = $request->lifestyle;
		$media= $request->media;
		$holidays= $request->holidays;
		$politics= $request->politics;
		$religion= $request->religion;
		$society= $request->society;
		$transportation= $request->transportation;
		$wars= $request->wars;
		$work= $request->work;

//delete all records of that user in pivot table
		$mecanex_user= Auth::user()->mecanex_user;
		$mecanex_user->interest()->detach();

		//store input in pivot table

		$mecanex_user->interest()->sync([1=>['interest_score'=>$arts],2=>['interest_score'=>$disasters],3=>['interest_score'=>$education],4=>['interest_score'=>$environment],5=>['interest_score'=>$health],6=>['interest_score'=>$lifestyle],7=>['interest_score'=>$media], 8=>['interest_score'=>$holidays],9=>['interest_score'=>$politics],10=>['interest_score'=>$religion],11=>['interest_score'=>$society],12=>['interest_score'=>$transportation],13=>['interest_score'=>$wars],14=>['interest_score'=>$work]]);

		//$interests=Interest::all(array('short_name'));
		$user_interests=$mecanex_user->interest;


		foreach ($user_interests as $user_interest)
		{
			$short_name= $user_interest->short_name;
			$term=Term::where('term',$short_name)->firstOrFail();

			$mecanex_user->term()->sync([$term->id=>['user_score'=>$user_interest->pivot->interest_score/5]],false);
			$mecanex_user->profilescore()->sync([$term->id=>['profile_score'=>$user_interest->pivot->interest_score/5]],false);


		}

		return Redirect::route ('home')->with ('message','Your interests were updated');
	}



	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}

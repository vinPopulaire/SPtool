<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', ['as'=>'home','uses'=>'HomeController@index']);
Route::get('terms', ['as'=>'terms','uses'=>'TermsController@show']);

/*   to path  auth/register kanei getRegister kai kalei view auth/register  */
/*   kai  password/email                */





Route::get('facebook/login', ['as'=>'fblogin','uses' =>'FacebookLoginController@login']);
Route::get('facebook/callback', ['as'=>'fbcallback','uses' =>'FacebookLoginController@callback']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



/*Profile */
//check for resourceful

//Route::get('profile/create',['middleware'=>'createProfile','as'=>'profile.create','uses'=> 'ProfileController@create']);
Route::get('profile/create',['as'=>'profile.create','uses'=> 'ProfileController@create']);
//Route::get('profile',['middleware'=>'hasProfile','as'=>'profile.show','uses'=> 'ProfileController@show']);
Route::get('profile',['as'=>'profile.show','uses'=> 'ProfileController@show']);
Route::put('profile',['as'=>'profile.update','uses'=> 'ProfileController@update']);
Route::post('profile',['as'=>'profile.store','uses'=> 'ProfileController@store']);
Route::get ('profile/edit', ['as'=>'profile.edit', 'uses'=>'ProfileController@edit']);
Route::delete ('profile/delete', ['as'=>'profile.delete', 'uses'=>'ProfileController@destroy']);


//Interests
Route::get ('interest/create', ['as'=>'interest.create', 'uses'=>'InterestController@create']);
Route::get ('interest/edit', ['as'=>'interest.edit', 'uses'=>'InterestController@edit']);
Route::post ('interest', ['as'=>'interest.store', 'uses'=>'InterestController@store']);
Route::get('interest',['as'=>'interest.show','uses'=> 'InterestController@show']);
Route::put('interest',['as'=>'interest.update','uses'=> 'InterestController@update']);

//Video actions
Route::get('video/recommendation',['as'=>'video.recommendation','uses'=> 'VideoController@search']);
Route::get('video/{id}',['as'=>'video.show','uses'=> 'VideoController@show']);
Route::post('video/explicitrf',['as'=>'video.rf','uses'=>'VideoController@rf']);

/*Import Controller */
Route::get('import', 'ImportController@import');
Route::get('scores', 'ImportController@scores');







/*API  MecanexUser registration etc.*/
Route::group(array('prefix' => 'api/v1'), function()
{
	//register user
Route::resource ('mecanexuser','MecanexUserController');

//fill the lists
Route::resource ('genders','GenderController');
Route::resource ('countries','CountriesController');
Route::resource ('occupations','OccupationsController');
Route::resource ('age','AgeController');
Route::resource ('education','EducationController');

//	user preferences
Route::resource('interest','InterestApiController');

//Facebook Login Test
Route::post('fblogin', 'FacebookApiController@login');

//Search, Retrieve and Recommend videos
Route::post('search', 'SearchController@search');

Route::resource ('actions','ActionsApiController');

//Signals Receiver
Route::post('videosignals', 'SignalsApiController@signals');

//VCI send user profile vector
Route::get('userprofile/{username}','VciApiController@show');

});




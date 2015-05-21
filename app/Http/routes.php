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

/*   to path  auth/register kanei getRegister kai kalei view auth/register  */
/*   kai  password/email                */


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


/* Is it resource ??
 * Route::resource('profile', 'ProfileController',['names' => ['create' => 'profile.create']]);
 *Route::resource('profile', 'ProfileController',['names' => ['show' => 'profile.show']]);
 * Route::resource('profile', 'ProfileController',['names' => ['update' => 'profile.update']]);
 * Route::resource('profile', 'ProfileController',['names' => ['store' => 'profile.store']]);
 * Route::resource('profile', 'ProfileController',['names' => ['edit' => 'profile.edit']]);
 */

/*API  MecanexUser registration etc.*/
Route::group(array('prefix' => 'api/v1'), function()
{
Route::resource ('mecanexuser','MecanexUserController');

Route::resource ('genders','GenderController');
Route::resource ('countries','CountriesController');
Route::resource ('occupations','OccupationsController');
Route::resource ('age','AgeController');
Route::resource ('education','EducationController');
});


/*Import Controller */
Route::get('video/import', 'ImportController@import');
Route::get('video/index', 'ImportController@index');
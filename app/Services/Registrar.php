<?php namespace App\Services;

use App\MecanexUser;
use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;


class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{



		return Validator::make($data, [

			'email' => 'required|email|max:255|unique:users',
			'username' => 'required|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'terms' => 'required'
		]);


	}



	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{



		return User::create([

			'email' => $data['email'],
			'username' => $data['username'],
			'password' => bcrypt($data['password']),
		]);

//		$user = new User(array(
//
//			'email' => $data['email'],
//			'username' => $data['username'],
//			'password' => bcrypt($data['password']),
//		));
//
//		$mecanex_user = new MecanexUser(array(
//			'username' => $data['username']
//		));
//
//		$user->save();
//		$mecanex_user = $user->mecanex_user()->save($mecanex_user);
//
//		return $user;

	}

}

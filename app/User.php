<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use Illuminate\Auth\UserInterface;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract{

	use Authenticatable, CanResetPassword, SyncableGraphNodeTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'surname','username','email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token','access_token'];

	//
	protected static $graph_node_field_aliases = [
		'id' => 'facebook_user_id'];


	public function profile()
	{

		return $this->hasOne('App\Profile');

	}

	public function mecanex_user()
	{

		return $this->hasOne('App\MecanexUser');

	}

}

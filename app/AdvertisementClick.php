<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertisementClick extends Model {

	protected $table = "advertisements_users_clicks";

	protected $fillable =['mecanex_user_id','content_id','clicks'];

}

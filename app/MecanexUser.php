<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MecanexUser extends Model {

	//
   protected  $hidden = array('id','remember_token','created_at','updated_at');
    protected $table = 'mecanex_users';
    protected $fillable = ['username','name','surname','gender_id','age_id','occupation_id','country_id','education_id','facebook_account','twitter_account'];

    public function gender()
    {

        return $this->belongsTo('App\Gender');

    }

    public function age()
    {

        return $this->belongsTo('App\Age');

    }

    public function country()
    {

        return $this->belongsTo('App\Country');

    }

    public function occupation()
    {

        return $this->belongsTo('App\Occupation');

    }

    public function education()
    {

        return $this->belongsTo('App\Education');

    }
}

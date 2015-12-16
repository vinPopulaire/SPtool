<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;

class MecanexUser extends Model {

    use SyncableGraphNodeTrait;

	//
   protected  $hidden = array('id','user_id','remember_token','created_at','updated_at');
   protected $table = 'mecanex_users';
   protected $fillable = ['username','name','surname','gender_id','age_id','occupation_id','country_id','education_id','facebook_account','twitter_account'];

   protected static $graph_node_field_aliases = [
        'id' => 'facebook_user_id',

   ];
    public function user()
    {

        return $this->belongsTo('App\User');

    }

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

    public function term()
    {

        return $this->belongsToMany('App\Term', 'users_terms_scores')->withPivot('user_score');

    }



    public function interest()
    {

        return $this->belongsToMany('App\Interest','users_interests_scores')->withPivot('interest_score');

    }

    public function action()
    {

        return $this->belongsToMany('App\Action');

    }

    public function profilescore()
    {

        return $this->belongsToMany('App\Term', 'users_terms_profilescores')->withPivot('profile_score');

    }

    //both were created for the online experiments

    public function opinion()
    {

        return $this->hasOne('App\Opinion');

    }

    public function dcg()
    {

        return $this->hasOne('App\Dcg');

    }

}

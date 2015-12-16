<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','surname','gender_id','age_id','occupation_id','country_id','education_id','facebook_account','twitter_account'];

    //relation of User and Profile

    public function user()
    {

        return $this->belongsTo('App\User');

    }

    //relation of Profile and Gender
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
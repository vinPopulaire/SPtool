<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model {

    protected $fillable = ['id','interest'];

    //

    public function mecanex_user()
    {

        return $this->belongsToMany('App\MecanexUser','users_interests_scores')->withPivot('interest_score');

    }

    public function short_name()
    {
        return $this->short_name;
    }

}

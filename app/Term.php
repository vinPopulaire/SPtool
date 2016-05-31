<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{

    protected $fillable = ['term'];

    //
    public function mecanexuser()
    {

        return $this->belongsToMany('App\MecanexUser', 'users_terms_scores')->withPivot('user_score');

    }



    public function videos()
    {

        return $this->belongsToMany('App\Video', 'videos_terms_scores')->withPivot('video_score');

    }

    public function enrichments()
    {

        return $this->belongsToMany('App\Enrichment', 'enrichments_terms_scores')->withPivot('enrichment_score');

    }


    public function profilescores()
    {

        return $this->belongsToMany('App\Video', 'users_terms_profilescores')->withPivot('profile_score');

    }
}
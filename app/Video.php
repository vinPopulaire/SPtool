<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {

    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['video_id','genre','topic','geographical_coverage','thesaurus_terms','title','local_keywords','summary'];



    public function term()
    {

        return $this->belongsToMany('App\Term', 'videos_terms_scores')->withPivot('video_score');


    }

    public function user()
    {

        return $this->belongsToMany('App\MecanexUser', 'user_videos')->withPivot('seen');

    }
}

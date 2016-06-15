<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrichment extends Model {

    protected $table = 'enrichments';

    protected $fillable = ['enrichment_id','class','longName','dbpediaURL','wikipediaURL','decription','thumbnail'];



    public function term()
    {

        return $this->belongsToMany('App\Term', 'enrichments_terms_scores')->withPivot('enrichment_score');


    }

    public function video()
    {

        return $this->belongsToMany('App\Video', 'enrichments_videos_times')->withPivot('time');


    }

}

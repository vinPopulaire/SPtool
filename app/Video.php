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


}

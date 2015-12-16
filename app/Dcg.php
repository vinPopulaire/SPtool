<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Dcg extends Model {

    protected $fillable = ['mecanex_user_id','video_id','rank','explicit_rf'];

    //
    public function user()
    {

        return $this->belongsTo('App\MecanexUser');

    }

}

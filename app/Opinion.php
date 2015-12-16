<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model {

    protected $fillable = ['mecanex_user_id','opinion'];

    //
    public function user()
    {

        return $this->belongsTo('App\MecanexUser');

    }

}

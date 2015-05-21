<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model {

	//
    protected $fillable = ['education'];

    public function profile()
    {

        return $this->hasMany('App\Profile');

    }

    public function mecanexuser()
    {

        return $this->hasMany('App\MecanexUser');

    }
}

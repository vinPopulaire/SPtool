<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model {

	//
    protected $fillable = ['occupation'];

    public function profile()
    {

        return $this->hasMany('App\Profile');

    }

    public function mecanexuser()
    {

        return $this->hasMany('App\MecanexUser');

    }
}

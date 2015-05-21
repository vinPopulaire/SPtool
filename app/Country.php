<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

	//
    protected $fillable = ['country'];

    public function profile()
    {

        return $this->hasMany('App\Profile');

    }

    public function mecanexuser()
    {

        return $this->hasMany('App\MecanexUser');

    }


}

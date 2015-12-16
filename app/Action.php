<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model {

    public function mecanexuser()
    {

        return $this->belongsToMany('App\MecanexUser');

    }

}

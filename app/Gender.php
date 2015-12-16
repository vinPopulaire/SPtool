<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model {

    protected $table = 'gender';
	//

    protected $fillable = ['gender'];

// define the relationship
    public function profile()
    {

        return $this->hasMany('App\Profile');

    }
    public function mecanexuser()
    {

        return $this->hasMany('App\MecanexUser');

    }
}

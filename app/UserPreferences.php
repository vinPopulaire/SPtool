<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPreferences extends Model {

    protected $table = 'user_preferences';
    protected $fillable = ['mecanex_user_id','arts','disasters','education','environment','health','lifestyle','media','holidays','politics','religion','society','transportation','wars','work'];
    protected  $hidden = array('id','mecanex_user_id','remember_token','created_at','updated_at');

    public function mecanexuser()
    {

        return $this->belongsTo('App\MecanexUser');

    }

}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MecanexUserTermHomeTermNeighbour extends Model {

	//This model corresponds to the link adjacency matrix

    protected $fillable = [
        'mecanex_user_id',
        'term_home_id',
        'term_neighbor_id',
        'score'
    ];


    public function mecanexUser()
    {
        return $this->belongsTo('App\MecanexUser');
    }

    public function termHome()
    {
        return $this->belongsTo('App\Term');
    }

    public function termNeighbour()
    {
        return $this->belongsTo('App\Term');
    }

}


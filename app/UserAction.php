<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAction extends Model {

    protected $fillable =['username','device_id','video_id','action','content_id','time','explicit_rf','weight','importance'];





}

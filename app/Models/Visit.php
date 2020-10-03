<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{

    protected $fillable = [
        'user_id',
        'reason_ov',
        'date_ov',
        'note',
        'status',
    ];      

    public function visitor()
    {
        return $this->belongsTo('App\Models\User');
    }  

    public function travelHistory() 
    {
        return $this->hasMany('App\Models\TravelHistory');
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelHistory extends Model
{

    protected $fillable = [
        'visitor_id', 
        'address', 
        'date_visited',
        'length_of_stay',
    ]; 

    public function visitor()
    {
        return $this->belongsTo('App\Models\Visit');
    }  

}
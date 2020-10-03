<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequiredDocument extends Model
{

    protected $fillable = [
        'parent_location',
        'location_id',
        'document_name',
        'set_by',
    ];    

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'territory', 'id');
    }       

    public function userDocument()
    {
    	return $this->hasMane('App\Models\UserDocument');
    }

}
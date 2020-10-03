<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{

    protected $fillable = [
        'user_id',
        'required_document_id',
        'expiry_date',
        'status',
        'group_id',
    ];    

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }       

    public function document()
    {
    	return $this->hasOne('App\Models\RequiredDocument');
    }

}
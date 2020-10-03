<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{

    protected $fillable = [
        'user_id',
        'code',
        'sent_to',
        'expire_at',
    ]; 

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expire_at' => 'datetime',
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{

    protected $fillable = [
        'user_id',
        'profile_photo',
        'phone_number',
        'phone_number_verified_at',
        'dob',
        'poi_id',
        'qr_filename',
    ];  

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone_number_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }   

    public function scopePoi($query, string $id)
    {
        return $query->where('poi_id', $id);
    }

    public function scopeFindByUser($query, string $id)
    {
    	return $query->where('user_id', $id)->first();
    }

}
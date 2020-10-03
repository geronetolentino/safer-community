<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'status'
    ];

    public function account()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function patients()
    {
        return $this->hasMany('App\Models\HospitalPatient','hospital_id','id');
    }

    public function scopeFindByUser($query, string $id)
    {
        return $query->where('user_id', $id)->first();
    }

    public function getHospitalStatusAttribute(): array
    {
        $status = [
            0 => ['text'=>'Deactivated','color'=>'danger'],
            1 => ['text'=>'Active','color'=>'success'],
        ];

        return $status[$this->status];
    }
}

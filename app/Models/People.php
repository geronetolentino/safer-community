<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{

    protected $fillable = [
        'head_type',
        'head_id',
        'child_id',
        'status',
    ]; 

    public function resident()
    {
        return $this->belongsTo('App\Models\User','child_id','id');
    }

    public function deployedBranch()
    {
        return $this->hasOne('App\Models\EstablishmentEmployee','user_id','child_id');
    }

    public function scopeEstablishment($query, string $id)
    {
        return $query->where('head_id', $id);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function getEmployeeStatusAttribute(): array
    {
        $status = [
            0 => ['text'=>'Enroll Requested','color'=>'danger'],
            1 => ['text'=>'Approved/Current Employee','color'=>'success'],
        ];

        return $status[$this->status];
    }
    
}

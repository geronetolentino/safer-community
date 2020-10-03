<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstablishmentEmployee extends Model
{
    protected $fillable = [
        'establishment_id',
        'user_id',
        'status',
    ];

    public function resident()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Establishment','establishment_id','id');
    }

    public function scannerAccess()
    {
        return $this->hasMany('App\Models\EstablishmentScannerAccess','employee_id','id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function scopeUser($query, string $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeFindByEstId($query, string $id)
    {
        return $query->where('establishment_id', $id);
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

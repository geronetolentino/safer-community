<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    protected $fillable = [
        'user_id',
        'parent_id',
        'name',
        'description',
        'logo',
        'est_code',
        'status',
    ];

    public function account()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function employees()
    {
        return $this->hasMany('App\Models\EstablishmentEmployee','establishment_id','id');
    }

    public function scanners()
    {
        return $this->hasMany('App\Models\Scanner','owner_id','id')->where('owner_type', 6);
    }

    public function scopeFindByUser($query, string $id)
    {
        return $query->where('user_id', $id)->first();
    }

    public function scopeFindByEc($query, string $id)
    {
        return $query->where('est_code', $id)->firstOrfail();
    }

    public function scopeBranches($query, string $id)
    {
        return $query->where('parent_id', $id)->orWhere('id', $id);
    }
    
    public function getEstablishmentStatusAttribute(): array
    {
        $status = [
            0 => ['text'=>'Deactivated','color'=>'danger'],
            1 => ['text'=>'Active','color'=>'success'],
        ];

        return $status[$this->status];
    }
}

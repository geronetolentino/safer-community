<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitingResident extends Model
{
    protected $guarded = [];

    public function scopeFindByAddrMunicipal($query, string $id)
    {
        return $query->where('des_addr_municipality_id', $id);
    }

    public function purpose()
    {
        return $this->belongsTo('App\Models\Purposes', 'reason_visit', 'id');
    }
}

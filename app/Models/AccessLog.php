<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{

    protected $fillable = [
        'accessor_id',
        'data_owner_id',
        'data_owner_approved',
        'information',
        'is_accessed',
    ];  

    public function accessedBy()
    {
        return $this->belongsTo('App\Models\User','accessor_id','id');
    }  

    public function dataOwner()
    {
        return $this->belongsTo('App\Models\UserInfo','data_owner_id','poi_id')->where('type', 4);
    }  

    public function scopeFindByAccessor($query, string $id)
    {
        return $query->where('accessor_id', $id);
    }

    public function scopeFindByPoi($query, string $id)
    {
        return $query->where('data_owner_id', $id);
    }

}

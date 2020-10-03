<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthData extends Model
{

    protected $fillable = [
        'poi_id',
        'current_status',
        'quarantine_period',
        'set_by',
        'hci_locked',
    ]; 

    public function resident()
    {
        return $this->belongsTo('App\Models\UserInfo','poi_id','poi_id');
    }

    public function patient()
    {
        return $this->hasOneThrough(
            'App\Models\User',
            'App\Models\UserInfo',
            'poi_id', 
            'user_id', 
            'id', 
            'poi_id' 
        );
    }

    public function healthTests()
    {
        return $this->hasMany('App\Models\HealthTest','health_data_id','id');
    }

    public function scopeCase($query, string $id) 
    {
        return $query->where('current_status', $id);
    }

    public function scopePoi($query, string $poi) 
    {
        return $query->where('poi_id', $poi);
    }

    public function scopePoids($query, array $ids) 
    {
        return $query->whereIn('poi_id', $ids);
    }

}

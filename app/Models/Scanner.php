<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scanner extends Model
{

    protected $fillable = [
        'owner_id',
        'owner_type',
        'name',
        'uid',
        'pin_id',
        'pin_code',
        'device_id',
        'status',
    ]; 

    public function assignedTo()
    {
    	return $this->hasOne('App\Models\EstablishmentScannerAccess', 'scanner_id', 'id');
    }  

    public function establishment()
    {
    	return $this->hasOne('App\Models\Establishment', 'owner_id', 'id')->where('owner_type', 6);
    }  

    public function scopeFindByUid($query, string $id)
    {
        return $query->where('uid', $id)->where('owner_type',6);
    }

    public function scopeFindByEstId($query, string $id)
    {
        return $query->where('owner_id', $id)->where('owner_type',6);
    }

    public function getScannerStatusAttribute(): array
    {
        $list = [
            0 => ['text'=>'Offline','color'=>'danger'],
            1 => ['text'=>'Online','color'=>'success'],

        ];

        return $list[$this->status];
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddrProvince extends Model
{
    protected $table = 'philippine_provinces';

    protected $fillable = [
        'user_id',
        'psgc_code',
        'province_description',
        'region_code',
        'province_code',
    ];       

    public function account()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->where('type', 2);
    } 

    public function region()
    {
        return $this->belongsTo('App\Models\AddrRegion','region_code','region_code');
    }  

    public function municipality()
    {
    	return $this->hasMany('App\Models\AddrMunicipality', 'province_code', 'province_code');
    }

    public function scopeProvinceCode($query, string $id)
    {
        return $query->where('province_code', $id);
    }

    public function scopeRegionCode($query, string $id)
    {
        return $query->where('region_code', $id);
    }

}
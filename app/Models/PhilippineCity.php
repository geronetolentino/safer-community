<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhilippineCity extends Model
{
    protected $fillable = [
        'user_id',
        'psgc_code',
        'city_municipality_description',
        'region_code',
        'province_code',
        'city_municipality_code',
    ];  

    public function account()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->where('type', 'lgu');
    } 

    public function residents()
    {
        return $this->hasMany('App\Models\User', 'addr_municipality_id', 'city_municipality_code')->where('type', 'resident');
    }    

    public function hospitals()
    {
        return $this->hasMany('App\Models\User', 'addr_municipality_id', 'city_municipality_code')->where('type', 'hci');
    }  

    public function province()
    {
        return $this->belongsTo('App\Models\PhilippineProvince','province_code','province_code');
    }  

    public function barangays()
    {
    	return $this->hasMany('App\Models\PhilippineBarangay', 'city_municipality_code', 'city_municipality_code');
    }

    public function scopeProvinceCode($query, string $id)
    {
        return $query->where('province_code', $id);
    }

    public function scopeCityMunicipalityCode($query, string $id)
    {
        return $query->where('city_municipality_code', $id);
    }

    public function scopeFindByUser($query, string $id)
    {
        return $query->where('user_id', $id)->first();
    }

}
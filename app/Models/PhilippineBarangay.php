<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhilippineBarangay extends Model
{
    protected $fillable = [
        'user_id',
        'barangay_code',
        'barangay_description',
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
        return $this->hasMany('App\Models\User', 'addr_barangay_id', 'barangay_code')->where('type', 'resident');
    }    

    public function hospitals()
    {
        return $this->hasMany('App\Models\User', 'addr_barangay_id', 'barangay_code')->where('type', 'hci');
    }    

    public function municipality()
    {
        return $this->belongsTo('App\Models\AddrMunicipality','city_municipality_code','city_municipality_code');
    }  

    public function scopeCityMunicipalityCode($query, string $id)
    {
        return $query->where('city_municipality_code', $id);
    }

    public function scopeMunicipalityOf($query, $param)
    {
        return $query->where($param[0], $param[1]);
    }

    public function scopeFindByUser($query, string $id)
    {
        return $query->where('user_id', $id)->first();
    }
        

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhilippineRegion extends Model
{
    protected $fillable = [
        'psgc_code',
        'region_description',
        'region_code',
    ]; 

    public function province()
    {
    	return $this->hasMany('App\Models\PhilippineProvince', 'region_code', 'region_code');
    }
}
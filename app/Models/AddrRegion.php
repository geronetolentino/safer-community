<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddrRegion extends Model
{
    protected $table = 'philippine_regions';

    protected $fillable = [
        'psgc_code',
        'region_description',
        'region_code',
    ]; 

    public function province()
    {
    	return $this->hasMany('App\Models\AddrProvince', 'region_code', 'region_code');
    }
}
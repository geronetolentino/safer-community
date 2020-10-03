<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lockdown extends Model
{

    protected $fillable = [
        'parent_location',
        'location_id',
        'expire_days',
        'set_by',
        'reason',
        'status',
    ]; 
}

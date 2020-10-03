<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthDataSetterLog extends Model
{

    protected $fillable = [
        'setter_id',
        'source',
        'source_id',
    ]; 

}

<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class EstablishmentScannerAccess extends Model
{
    protected $fillable = [
        'establishment_id',
        'employee_id',
        'scanner_id',
    ];

    public function scanner()
    {
        return $this->belongsTo('App\Models\Scanner','scanner_id','id');
    }

    public function establishment()
    {
        return $this->belongsTo('App\Models\Establishment','establishment_id','id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\EstablishmentEmployee','employee_id','id');
    }

    public function scopeFindByEmployee($query, string $id)
    {
        return $query->where('employee_id', $id);
    }

    public function scopeFindByEstId($query, string $id)
    {
        return $query->where('establishment_id', $id);
    }

    public function scopeFindByScanner($query, string $id)
    {
        return $query->where('scanner_id', $id);
    }

}
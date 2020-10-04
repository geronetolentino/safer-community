<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class HospitalPatient extends Model
{

    protected $fillable = [
        'hospital_id',
        'poi_id',
        'admit_date',
        'discharge_date',
        'discharge_request',
        'patient_status',
        'hci_locked',
    ]; 

    public function resident()
    {
        return $this->belongsTo('App\Models\UserInfo','poi_id','poi_id');
    }

    public function scopeMyPatients($query)
    {
        return $query->where('hospital_id', Auth::user()->id);
    }

    public function scopeFindByPoi($query, string $id)
    {
        return $query->where('poi_id', $id);
    }

    public function scopeStatus($query, string $id)
    {
        return $query->where('patient_status', $id);
    }

    public function scopeHci($query, string $id)
    {
        return $query->where('hospital_id', $id);
    }
}

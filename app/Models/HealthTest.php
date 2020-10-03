<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthTest extends Model
{

    protected $fillable = [
        'poi_id',
        'test_date',
        'test_result',
        'symptom_category',
        'remarks',
        'status',
        'hci_id',
    ]; 

    public function parentData()
    {
        return $this->belongsTo('App\Models\HealthData','health_data_id','id');
    }

    public function hci()
    {
        return $this->belongsTo('App\Models\Hospital','health_data_id','id');
    }

    public function scopeFindByPoi($query, string $id)
    {
        return $query->where('poi_id', $id);
    }

    public function scopeFindByHci($query, string $id) 
    {
        return $query->where('hci_id', $id);
    }

}

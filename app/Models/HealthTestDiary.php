<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthTestDiary extends Model
{

    protected $fillable = [
        'health_test_id',
        'procedures',
        'diagnosis',
        'data_date',
        'note',
        'hci_id',
    ]; 

    public function test()
    {
        return $this->belongsTo('App\Models\HealthDataTest','health_data_test_id','id');
    }

    public function hci()
    {
        return $this->belongsTo('App\Models\Hospital','health_data_id','id');
    }

    public function scopeFindByTestId($query, string $id)
    {
        return $query->where('health_test_id', $id);
    }

    public function scopeFindByHci($query, string $id) 
    {
        return $query->where('hci_id', $id);
    }

}

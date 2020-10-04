<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ChecklistDailyTotal extends Model
{

    protected $fillable = [
        'poi_id',
        'serious_symptoms',
        'less_common_symptoms',
        'date_submitted',
        'poi_condition',
        'group_id',
    ]; 

    public function resident()
    {
        return $this->belongsTo('App\Models\User','uid','poi_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\ChecklistDailyItem','group_id','group_id');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date_submitted', Carbon::today());
    }

    public function scopeGroup($query, string $id)
    {
        return $query->where('group_id', $id);
    }

    public function scopeFindByPoi($query, string $poi)
    {
        return $query->where('poi_id', $poi);
    }

    public function scopeCondition($query, string $id)
    {
        return $query->where('poi_condition', $id);
    }

    public function getConditionAttribute($query): array
    {

        $list = [
            'Good Condition' => ['text'=>'Good Condition','color'=>'success'],
            'Mild Condition' => ['text'=>'Mild Condition','color'=>'warning'],
            'Severe Condition' => ['text'=>'Severe Condition','color'=>'danger'],
        ];

        return $list[$this->poi_condition];
    }
}
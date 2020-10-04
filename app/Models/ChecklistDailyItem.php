<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistDailyItem extends Model
{

    protected $fillable = [
        'checklist_id',
        'group_id',
    ]; 

    public function checklist()
    {
        return $this->belongsTo('App\Models\Checklist','checklist_id','id');
    }

    public function scopeGroup($query, string $id)
    {
    	return $query->where('group_id', $id);
    }
}
<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EstablishmentVisitorLog extends Model
{
    protected $fillable = [
        'poi_id',
        'scanner_id',
        'est_code',
        'checkin',
        'checkout',
        'auto_checkout',
        'status',
    ];

    protected $dates = [
        'checkin', 
        'checkout'
    ];

    public function person()
    {
        return $this->belongsTo('App\Models\UserInfo','poi_id','poi_id');
    }

    public function establishment()
    {
        return $this->belongsTo('App\Models\Establishment','est_code','est_code');
    }

    public function scopePoi($query, string $id)
    {
        return $query->where('poi_id', $id);
    }

    public function scopeEstcode($query, string $id)
    {
        return $query->where('est_code', $id);
    }

    public function scopeCstatus($query, string $id)
    {
        return $query->where('status', $id);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    public function getIsAutoOutAttribute(): string
    {
        return $this->auto_checkout == true ? 'System Auto Checkout' : '';
    }

}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'type',
        'name', 
        'birthdate', 
        'gender', 
        'phone_number', 
        'password',
        'address',
        'addr_barangay_id',
        'addr_municipality_id',
        'addr_province_id',
        'addr_region_id',
        'update_count',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function uType()
    {
        return $this->belongsTo('App\Models\UserType','type','id');
    }

    public function info()
    {
        return $this->belongsTo('App\Models\UserInfo','id','user_id');
    }

    public function healthData()
    {
        return $this->hasOneThrough(
            'App\Models\HealthData',
            'App\Models\UserInfo',
            'user_id', 
            'poi_id', 
            'id', 
            'poi_id' 
        )->orderBy('id', 'desc');
    }

    public function hospital()
    {
        return $this->hasOne('App\Models\Hospital','user_id','id');
    }

    public function patient()
    {
        return $this->hasOneThrough(
            'App\Models\UserInfo',
            'App\Models\HospitalPatient',
            'poi_id',
            'poi_id',
            'id',
            'id',
        );
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification','user_id','id')->orderBy('id', 'DESC');
    }

    public function barangay()
    {
        return $this->belongsTo('App\Models\PhilippineBarangay','addr_barangay_id','barangay_code');
    }

    public function municipality()
    {
        return $this->belongsTo('App\Models\PhilippineCity','addr_municipality_id','city_municipality_code');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\PhilippineProvince','addr_province_id','province_code');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\PhilippineRegion','addr_region_id','region_code');
    }

    public function scopeResidents($query)
    {
        return $query->where('type', 'resident');
    }

    public function scopeResidentOf($query, $param)
    {
        return $query->where($param[0], $param[1])->where('type', 'resident');
    }

    public function getFullAddressAttribute(): string
    {   
        $address = $this->province->province_description;

        if ($this->type == 1) {

            $address = $address;

        } elseif ($this->type == 2) {

            $address .= ', '.$this->municipality->city_municipality_description;

        } else {

            $address .= ', '.$this->municipality->city_municipality_description.', '.$this->barangay->barangay_description;

        }

        return $address;
    }
}

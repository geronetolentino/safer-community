<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronEmailQueue extends Model
{

    protected $fillable = [
        'send_to',
        'sender_name',
        'content',
        'is_sent',
    ]; 
}
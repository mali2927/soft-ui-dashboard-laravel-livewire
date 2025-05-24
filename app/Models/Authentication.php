<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
    protected $fillable = [
        'emp_id',
        'authentication_datetime',
        'authentication_date',
        'authentication_time',
        'direction',
        'device_name',
        'device_serial_no',
        'person_name',
        'card_no',
    ];

    public $timestamps = true;
}

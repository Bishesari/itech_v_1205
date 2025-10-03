<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpLog extends Model
{

    protected $fillable = [
        'mobile_nu', 'request_ip', 'status', 'created', 'updated'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created = j_d_stamp_en(); // تابع شمسی خودت
        });

        static::updating(function ($model) {
            $model->updated = j_d_stamp_en();
        });
    }
}

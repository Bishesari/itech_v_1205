<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mobile extends Model
{
    protected $fillable = ['mobile_nu', 'created', 'updated'];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public static function storeOrUpdate($mobile_nu)
    {
        $mobile = self::updateOrCreate(
            ['mobile_nu' => $mobile_nu],
            ['updated'   => j_d_stamp_en()]
        );

        if ($mobile->wasRecentlyCreated) {
            $mobile->created = j_d_stamp_en();
            $mobile->save();
        }

        return $mobile;
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created = j_d_stamp_en();
        });

        static::updating(function ($model) {
            $model->updated = j_d_stamp_en();
        });
    }

}

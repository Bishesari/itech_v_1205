<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    public $timestamps = false;
    protected $fillable = ['mobile_nu', 'created', 'updated'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public static function storeOrUpdate($mobile_nu)
    {
        $contact = self::updateOrCreate(
            ['mobile_nu' => $mobile_nu],
            ['updated'   => j_d_stamp_en()]
        );

        if ($contact->wasRecentlyCreated) {
            $contact->created = j_d_stamp_en();
            $contact->save();
        }

        return $contact;
    }
    protected static function boot(): void
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

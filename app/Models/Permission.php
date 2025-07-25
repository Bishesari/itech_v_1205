<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    public $timestamps = false;
    protected $fillable = ['name_fa', 'name_en', 'created', 'updated'];

    public function roles():BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}

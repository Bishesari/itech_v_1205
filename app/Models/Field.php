<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Field extends Model
{
    public $timestamps = false;

    public function cluster():BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }

    public function skillStandards():HasMany
    {
        return $this->hasMany(SkillStandard::class);
    }
}

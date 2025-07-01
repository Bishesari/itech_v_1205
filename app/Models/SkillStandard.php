<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillStandard extends Model
{
    public $timestamps = false;
    public function field():BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function sections():HasMany
    {
        return $this->hasMany(StandardSection::class);
    }
}

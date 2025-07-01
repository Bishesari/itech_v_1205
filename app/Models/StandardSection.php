<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StandardSection extends Model
{
    public $timestamps = false;
    public function skillStandard():BelongsTo
    {
        return $this->belongsTo(SkillStandard::class);
    }
}

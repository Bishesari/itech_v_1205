<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Option extends Model
{
    public $timestamps = false;
    public function question():belongsTo
    {
        return $this->belongsTo(Question::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionLevel extends Model
{
    public $timestamps = false;
    public function questions():hasMany
    {
        return $this->hasMany(Question::class, 'level_id');
    }
}

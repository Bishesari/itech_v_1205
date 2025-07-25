<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    public $timestamps = false;
    public function options():hasmany
    {
        return $this->hasMany(Option::class);
    }
    public function level():BelongsTo
    {
        return $this->belongsTo(QuestionLevel::class, 'level_id');
    }
    public function type():BelongsTo
    {
        return $this->belongsTo(QuestionType::class, 'type_id');
    }
}

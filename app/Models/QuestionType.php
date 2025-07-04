<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionType extends Model
{
    public $timestamps = false;
    public function questions():hasMany
    {
        return $this->hasMany(Question::class, 'type_id');
    }
}

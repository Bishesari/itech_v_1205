<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    public $timestamps = false;
    public function options():hasmany
    {
        return $this->hasMany(Option::class);
    }
}

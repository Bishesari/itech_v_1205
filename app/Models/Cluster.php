<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Model
{
    public $timestamps = false;
    public function fields():HasMany
    {
        return $this->hasMany(Field::class);
    }
}

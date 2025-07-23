<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $fillable = ['short_name', 'full_name', 'abb', 'remain_credit', 'created','updated'];
    public $timestamps = false;
}

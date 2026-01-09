<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participate extends Model
{
    protected $fillable = ['user_id', 'event_id', 'present'];
}

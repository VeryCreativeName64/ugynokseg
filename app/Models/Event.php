<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'agency_id', 'limit', 'date', 'location', 'status'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'commerce_id', 'name', 'model', 'ip'
    ];

}

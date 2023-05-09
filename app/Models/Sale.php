<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    protected $fillable = [
        'device_id', 'payment', 'status', 'amount'
    ];

    public function devices(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }


}

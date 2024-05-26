<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type_id', 'gyarto'];


    public function type(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class, 'type_id');
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'type_id');
    }
}

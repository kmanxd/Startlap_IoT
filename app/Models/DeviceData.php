<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Device;

class DeviceData extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'fogyasztas', 'teljesitmeny', 'mukodesiido'];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Building extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'address',
        'number',
        'neighborhood',
        'postal_code',
        'latitude',
        'longitude',
        'responsible',
        'secretary_id',
        'active'
    ];

    public function toggleActive()
    {
        $this->active = !$this->active;
        $this->save();
    }

    public function secretary(): BelongsTo
    {
        return $this->belongsTo(Secretary::class, 'secretary_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
}

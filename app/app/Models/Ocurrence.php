<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Carbon\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
    
class Ocurrence extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'description',
        'start_date',
        'solution_date',
        'categories_ocurrences_id',
        'buildings_id',
        'users_id'
    ];

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function categoryOcurrence(): BelongsTo
    {
        return $this->belongsTo(CategoryOcurrence::class, 'categories_ocurrences_id');
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'buildings_id');
    }

    public function followups(): HasMany
    {
        return $this->hasMany(OcurrenceUpdate::class, 'ocurrences_id', 'id');   
    }

    public function toggleActive()
    {
        $this->active = !$this->active;
        $this->save();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

}

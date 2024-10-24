<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocurrence extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'start_date',
        'solution_date',
        'categories_ocurrences_id',
        'buildings_id',
        'users_id'
    ];

    public function user(): BelongsTo
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

    public function toggleActive()
    {
        $this->active = !$this->active;
        $this->save();
    }

}

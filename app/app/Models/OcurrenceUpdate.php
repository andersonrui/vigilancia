<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OcurrenceUpdate extends Model
{
    use HasFactory;

    protected $table = 'ocurrences_updates';

    protected $fillable = [
        'description',
        'user_id',
        'ocurrences_id'
    ];

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}

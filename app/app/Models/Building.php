<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

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

}

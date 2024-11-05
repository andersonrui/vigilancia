<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Secretary extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'active'
    ];

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

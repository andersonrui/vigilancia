<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOcurrence extends Model
{
    use HasFactory;

    protected $table = 'categories_ocurrences';

    protected $fillable = [
        'name',
        'active'
    ];

    public function toggleActive()
    {
        $this->active = !$this->active;
        $this->save();
    }

}

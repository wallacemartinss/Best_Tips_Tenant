<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description'
    ];

    public function mensures(): HasMany
    {
        return $this->hasMany(Mensure::class);
    }
}

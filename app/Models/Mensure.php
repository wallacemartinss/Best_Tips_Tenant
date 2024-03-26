<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mensure extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'unit_id',
        'name',
        'simbol',
        'description',
        'value'
    ];

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
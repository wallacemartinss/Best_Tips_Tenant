<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'name',
        'description',
        'active',
        'value',
        'duration',
    ];

    public function detailplans(): HasMany
    {
        return $this->hasMany(DetailPlan::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Departament extends Model
{
    use HasFactory;

    protected $fillable = [
        'sector_id',
        'company_id',
        'name', 
        'description',
        'active',
    ];
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
    
    public function company(): HasMany
    {
        return $this->hasMany(Company::class);
    }
    public function sector(): BelongsTo
    {
        return $this->BelongsTo(Sector::class);
    }


}

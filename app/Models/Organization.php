<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organization extends Model implements HasCurrentTenantLabel
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function getCurrentTenantLabel(): string
    {
        return 'Active organization';
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function companies(): HasMany
    {
        return $this->HasMany(company::class);
    }
    public function company_address(): HasMany
    {
        return $this->hasMany(CompanyAddress::class);
    }
    public function Departaments(): HasMany
    {
        return $this->HasMany(Departament::class);
    }
}

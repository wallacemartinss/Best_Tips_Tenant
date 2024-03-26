<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyType extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'name',
        'description',
    ];

    public function socialtaxes(): HasMany
    {
        return $this->hasMany(SocialTaxes::class);
    }

    public function labortaxes(): HasMany
    {
        return $this->hasMany(LaborTaxes::class);
    }
}

<?php

namespace App\Models;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function company_type(): BelongsTo
    {
        return $this->BelongsTo(CompanyType::class);
    }

    public function organization(): BelongsTo
    {
        return $this->BelongsTo(Organization::class);
    }

    public function company_address(): HasOne
    {
        return $this->hasOne(CompanyAddress::class);
    }

    public function labor_taxes(): BelongsTo
    {
        return $this->belongsTo(LaborTaxes::class);
    }

    public function Departaments(): BelongsTo
    {
        return $this->BelongsTo(Departament::class);
    }
}

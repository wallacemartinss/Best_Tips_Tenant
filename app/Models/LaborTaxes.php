<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LaborTaxes extends Model
{
    use HasFactory;

    protected $fillable = [

        'company_type_id',
        'name',
        'description',
        'value',
        'active',
    ];

    public function companytypes(): HasMany
    {
        return $this->hasMany(CompanyType::class);
    }
}

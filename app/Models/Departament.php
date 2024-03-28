<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->BelongsTo(Organization::class);
    }
    
    public function sectors(): BelongsTo
    {
        return $this->BelongsTo(Sector::class);
    }

    public function companies(): BelongsTo
    {
        return $this->BelongsTo(company::class);
    }

}

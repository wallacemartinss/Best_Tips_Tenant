<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyAddress extends Model
{
    use HasFactory;

    protected $fillable = [
            'organization_id',
            'company_id',
            'zip_code',
            'street',  
            'number',
            'district',
            'city',
            'state',
            'complement',
            'reference'
    ];

    public function companies(): BelongsTo
    {
        return $this->belongsTo(company::class);
    }
}

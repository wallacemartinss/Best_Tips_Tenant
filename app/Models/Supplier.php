<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number',
        'fantasy_name',
        'social_reason',
        'cnae_description',
        'cnae_code',
        'open_date',
        'email',
        'phone',
        'status',
        'zip_code',
        'street',
        'number',
        'district',
        'city',
        'state',
        'complement',
        'reference',
        
    ];
   
}

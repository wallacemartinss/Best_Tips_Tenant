<?php

namespace App\Models;


use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function company_type(): BelongsTo
    {
        return $this->belongsTo(CompanyType::class);
    }
 
    public function organization(): BelongsTo
    {
        return $this->BelongsTo(Organization::class);
    }


}

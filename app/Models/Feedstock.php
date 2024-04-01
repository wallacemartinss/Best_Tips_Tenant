<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedstock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'organization_id',
        'company_id',
        'mensures_id',
        'units_id',
        'description',
        'manufacturer',
        'quantity',
        'value',
        'calculate_value'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function units(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function mensures(): BelongsTo
    {
        return $this->belongsTo(Mensure::class);
    }
}

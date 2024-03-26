<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPlan extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'plan_id',
        'name',
        'description',
        'active',
    ];

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }
}
 
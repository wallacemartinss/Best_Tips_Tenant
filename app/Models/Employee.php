<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function departament(): BelongsTo
    {
        return $this->belongsTo(Departament::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function work_contract(): BelongsTo
    {
        return $this->belongsTo(WorkContract::class);
    }

}

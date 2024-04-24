<?php

use App\Models\Departament;
use App\Models\Organization;
use App\Models\WorkContract;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Departament::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(WorkContract::class)->constrained();
            $table->string('document_number')->unique();
            $table->string('frist_name');
            $table->string('last_name');
            $table->date('brith_date')->nullable();
            $table->date('admission_date');
            $table->time('jorney_work');
            $table->double('salary', 8, 2);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

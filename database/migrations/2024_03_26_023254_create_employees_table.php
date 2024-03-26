<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('departament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->constrained();
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

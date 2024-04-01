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
        Schema::create('feedstocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mensures_id')->constrained()->cascadeOnDelete();
            $table->foreignId('units_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->string('manufacturer')->nullable();
            $table->double('quantity', 8, 2);
            $table->double('value', 8, 2);
            $table->double('calculate_value', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedstocks');
    }
};

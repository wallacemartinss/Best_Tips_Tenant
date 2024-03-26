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
        Schema::create('social_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_type_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('description');
            $table->double('value', 8, 2);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_taxes');
    }
};

<?php

use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensures', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Unit::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('simbol');
            $table->string('description')->nullable();
            $table->double('value', 8, 2)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('mensures');
    }
};

<?php

use App\Models\CompanyType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CompanyType::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('description');
            $table->double('value', 8, 2);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('social_taxes');
    }
};

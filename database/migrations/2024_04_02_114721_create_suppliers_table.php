<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('fantasy_name')->nullable();
            $table->string('social_reason')->nullable();
            $table->string('status');
            $table->string('cnae_description')->nullable();
            $table->string('cnae_code')->nullable();
            $table->string('open_date')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();           
            $table->string('zip_code');
            $table->string('street');
            $table->string('number')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('complement')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};

<?php

use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('document_type');
            $table->string('document_number')->unique();
            $table->string('fantasy_name');
            $table->string('email');
            $table->string('phone');
            $table->string('slug')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('organization_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('social_reason')->nullable();
            $table->string('company_size')->nullable();
            $table->string('legal_nature')->nullable();
            $table->string('share_capital')->nullable();
            $table->string('status')->nullable();;
            $table->string('simei_situation')->nullable();
            $table->string('simple_situation')->nullable();
            $table->string('open_date')->nullable();
            $table->string('state_registration_number')->nullable() ;
            $table->string('state_registration_status')->nullable();   
            $table->string('state_registration_name')->nullable();
            $table->string('state_registration_acronym')->nullable();
            $table->string('especial_situation')->nullable();
            $table->string('registration_situation_reason')->nullable();
            $table->string('registration_situation_reason_data')->nullable();    
            $table->timestamps();
        });
     
        Schema::create('organization_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('zip_code');
            $table->string('street');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('complement')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();
        });

        Schema::create('organization_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class)->nullable()->constrained()->cascadeOnDelete();
            $table->json('primary_activitie')->nullable();
            $table->json('secondary_activitie')->nullable(); 
            $table->timestamps();
        });

        Schema::create('organization_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class)->index();
            $table->foreignIdFor(User::class)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('organization_details');
        Schema::dropIfExists('organization_addresses');
        Schema::dropIfExists('organization_activities');
        Schema::dropIfExists('organization_user');
    }
};

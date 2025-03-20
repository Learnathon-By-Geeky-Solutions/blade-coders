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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('short_brief');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_text')->nullable();
            $table->string('title');
            $table->text('about');
            $table->text('youtube_link');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('benefit_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('benefit_id')->constrained('benefits');
            $table->foreignId('service_id')->constrained('services');
            $table->unique(['benefit_id', 'service_id']);
        });

        Schema::create('ability_support_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ability_support_id')->constrained('ability_supports');
            $table->foreignId('service_id')->constrained('services');
            $table->unique(['ability_support_id', 'service_id']);
        });

        Schema::create('our_process_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('our_process_id')->constrained('our_processes');
            $table->foreignId('service_id')->constrained('services');
            $table->unique(['our_process_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('benefit_service');
        Schema::dropIfExists('ability_support_service');
        Schema::dropIfExists('our_processes');
    }
};

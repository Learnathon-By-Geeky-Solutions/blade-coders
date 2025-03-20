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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('event_type_id')->constrained('event_types')->cascadeOnDelete();
            $table->string('name');
            $table->text('short_brief');
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('location');
            $table->string('button_text')->nullable();
            $table->string('title');
            $table->text('about');
            $table->text('youtube_link');
            $table->json('agenda')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('event_event_speaker', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('event_speaker_id')->constrained('event_speakers')->cascadeOnDelete();
            $table->unique(['event_id', 'event_speaker_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

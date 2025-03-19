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
        Schema::create('parent_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('parent_designation');
            $table->text('feedback');
            $table->decimal('rating', 2, 1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_reviews');
    }
};

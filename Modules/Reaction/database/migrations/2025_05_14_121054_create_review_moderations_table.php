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
        Schema::create('review_moderations', function (Blueprint $table) {
            $table->id();
            $table->integer('review_id');
            $table->string('status');
            $table->timestamps();

            // Define foreign key constraint
            $table->foreignId('review_id')
                  ->constrained('reviews')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_moderations');
    }
};

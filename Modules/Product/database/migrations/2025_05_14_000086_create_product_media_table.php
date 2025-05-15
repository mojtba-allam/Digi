<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('product_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('media_type');
            $table->string('url');
            $table->foreignId('media_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_variant_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('promotion_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('media_order');
            $table->string('alt_text');
            $table->string('caption');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('product_media');
    }
};

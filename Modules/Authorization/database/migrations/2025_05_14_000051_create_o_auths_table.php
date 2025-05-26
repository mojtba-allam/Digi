<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('o_auths', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->integer('provider_id');
            $table->unsignedBigInteger('authenticatable_id');
            $table->string('authenticatable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oauth');
    }
};

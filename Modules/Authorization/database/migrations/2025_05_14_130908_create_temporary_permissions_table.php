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
        Schema::create('temporary_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('granted_at');
            $table->foreignId('role_id') ->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('expires_at');
            $table->string('condition');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_permissions');
    }
};


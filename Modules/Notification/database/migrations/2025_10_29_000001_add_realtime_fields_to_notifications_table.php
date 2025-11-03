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
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('type')->default('general')->after('body');
            $table->json('data')->nullable()->after('type');
            $table->string('action_url')->nullable()->after('data');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('action_url');
            
            // Add indexes for better performance
            $table->index(['user_id', 'read_at']);
            $table->index(['type', 'created_at']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'read_at']);
            $table->dropIndex(['type', 'created_at']);
            $table->dropIndex(['priority']);
            
            $table->dropColumn(['type', 'data', 'action_url', 'priority']);
        });
    }
};
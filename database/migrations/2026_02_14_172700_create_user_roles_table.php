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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role_tag'); // Directly store role tag
            $table->timestamps();

            // Optional: Foreign key constraint
            $table->foreign('role_tag')
                  ->references('tag')
                  ->on('roles')
                  ->onDelete('cascade');

            // Unique constraint to prevent duplicate assignments
            $table->unique(['user_id', 'role_tag']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};

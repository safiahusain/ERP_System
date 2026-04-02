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
        Schema::create('role_functionalities', function (Blueprint $table) {
            $table->id();
            $table->string('role_tag'); // role_id ki jagah role_tag
            $table->foreignId('functionality_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Foreign key constraint with roles table (via tag)
            $table->foreign('role_tag')
                  ->references('tag')
                  ->on('roles')
                  ->onDelete('cascade');

            // Unique constraint to prevent duplicate assignments
            $table->unique(['role_tag', 'functionality_id']);

            // Index for performance
            $table->index('role_tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_functionalities');
    }
};

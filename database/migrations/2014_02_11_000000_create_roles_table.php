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
        // Step 1: Pehle table banao without foreign key
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag')->unique();
            $table->boolean('is_system')->default(0);
            $table->string('linked_role_tag')->nullable();
            $table->timestamps();
        });

        // Step 2: Ab index add karo
        Schema::table('roles', function (Blueprint $table) {
            $table->index('tag'); // Already hai unique se, but ensure kar rahe
        });

        // Step 3: Phir foreign key add karo
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('linked_role_tag')
                  ->references('tag')
                  ->on('roles')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

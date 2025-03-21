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
        Schema::table('users', function (Blueprint $table) {
            // Relation One-to-Many entre users et roles
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
    
            // Relation One-to-One entre users et recruteurs
            $table->foreignId('recruteur_id')->nullable()->constrained('recruteurs')->onDelete('cascade');
    
            // Relation One-to-One entre users et candidatures
            $table->foreignId('candidature_id')->nullable()->constrained('candidatures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['recruteur_id']);
            $table->dropForeign(['candidature_id']);
        });
    }
};

<?php
// database/migrations/xxxx_create_conges_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('type');
            $table->text('motif')->nullable();
            $table->string('statut')->default('En attente'); // 'En attente', 'Approuvé', 'Refusé'
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
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
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->morphs('cible_type', 'cible_id');
            $table->string('motif')->comment('Raison du signalement');
            $table->text('description')->nullable()->comment('Détails supplémentaires du signalement');
            $table->enum('statut', ['pending', 'resolved', 'rejected'])->default('pending');
            $table->dateTime('traitement_date')->nullable();
            $table->text('traitement_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};

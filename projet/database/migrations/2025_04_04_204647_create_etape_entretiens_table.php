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
        Schema::create('etape_entretien_orale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidature_id')->constrained('candidatures')->onDelete('cascade');
            $table->string('statut')->default('en attente'); // en_attente, en_cours, valide
            $table->string('adresse')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etape_entretiens');
    }
};

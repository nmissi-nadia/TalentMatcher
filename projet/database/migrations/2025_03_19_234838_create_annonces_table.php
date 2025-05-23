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
    Schema::create('annonces', function (Blueprint $table) {
        $table->id();
        $table->string('titre');
        $table->text('description');
        $table->string('location');
        $table->string('competences');
        $table->decimal('salaire', 10, 2);
        $table->foreignId('categorie_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('recruteur_id')->constrained('users')->onDelete('cascade');
        $table->enum('statut', ['ouverte', 'fermée'])->default('ouverte');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};

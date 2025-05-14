<?php

use App\Models\departement;
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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 255);
            $table->string('prenom', 255);
            $table->string('email', 255);
            $table->string('telephone', 255);
            $table->string('image', 255)->nullable();
            $table->foreignIdFor(departement::class);
            $table->integer('montant_journalier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};


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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compte_id');
            $table -> enum('type', ['validation','closure']);
            $table->enum('statut', ['en attente', 'active', 'rejete'])->default('en attente');
            $table -> text('raison_rejet')->nullable();
            $table -> date('date_demande');
            $table -> timestamp('date_traitement');
            $table->timestamps();

            $table->foreign('compte_id')->references('id')->on('compte_bancaire')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};

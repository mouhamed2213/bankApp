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
        // On dit à Laravel de modifier la table 'compte_bancaire'
        Schema::table('compte_bancaire', function (Blueprint $table) {
            // On ajoute la colonne pour compter les retraits du mois.
            // On la met à 0 par défaut.
            $table->integer('retraits_mensuels')->default(0)->after('status');

            // On ajoute la colonne pour savoir quand le compteur a été remis à zéro.
            // Elle peut être nulle au début.
            $table->timestamp('date_dernier_reset_retrait')->nullable()->after('retraits_mensuels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cette partie sert à annuler la migration si besoin
        Schema::table('compte_bancaire', function (Blueprint $table) {
            $table->dropColumn(['retraits_mensuels', 'date_dernier_reset_retrait']);
        });
    }
};

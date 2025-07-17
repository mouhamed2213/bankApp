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
        Schema::create('virtual_cards', function (Blueprint $table) {
        $table->id();
        $table ->string('numero_carte')->unique();
        $table -> date('date_creation');
        $table -> dateTime('date_expiration');
        $table -> string('CVV');
        $table -> string ('status');
        $table -> unsignedBigInteger('compte_id');
        $table->timestamps(); // expired date

        $table->foreign('compte_id') -> references('id')->on('compte_bancaire')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_cards');
    }
};

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
        Schema::create('compte_bancaire', function (Blueprint $table) {
            Schema::create('compte_bancaire', function (Blueprint $table) {
                $table->id();
                $table->string('numero_compte', 11)->unique();
                $table->string('code_banque', 5 )->unique();
                $table->string('code_guichet', 5 )->unique();
                $table->string('RIB',2 )->unique();
                $table->decimal('solde',15);
                $table->string('type_de_compte')->default('courant');
                $table->string('status')->default('en attente');
                $table->unsignedBigInteger('user_id'); // clee etrangere
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compte_bancaire');
    }
};

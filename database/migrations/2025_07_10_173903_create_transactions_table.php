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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type_transaction');
            $table->double('montant');
            $table->unsignedBigInteger('compte_source_id');
            $table->unsignedBigInteger('compte_dest_id')->nullable();
            $table->timestamps();

            //  relation : transaction belongTo compte
            $table->foreign('compte_source_id')->references('id')->on('compte_bancaire')->onDelete('cascade');
            $table->foreign('compte_dest_id')->references('id')->on('compte_bancaire')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

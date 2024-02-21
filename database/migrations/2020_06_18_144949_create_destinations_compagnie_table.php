<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationsCompagnieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinations_compagnie', function (Blueprint $table) {
            $table->id();
            $table->string('pays_destination')->nullable();
            $table->string('ville_destination')->nullable();
            $table->integer('nbre_places')->nullable();
            $table->integer('nbre_places_dispo')->nullable();
            $table->double('prix_unitaire');
            $table->time('heure')->nullable();
            $table->string('pays_demarrage')->nullable();
            $table->string('ville_demarrage')->nullable();
            $table->string('jour')->nullable();
            $table->unsignedBigInteger('status')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destinations_compagnie');
    }
}
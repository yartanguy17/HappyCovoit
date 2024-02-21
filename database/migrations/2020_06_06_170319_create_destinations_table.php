<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('pays_destination')->nullable();
            $table->string('ville_destination')->nullable();
            $table->integer('nbre_places')->nullable();
            $table->integer('nbre_places_dispo')->nullable();
            $table->double('prix_unitaire');
            $table->time('heure')->nullable();
            $table->string('pays_demarrage')->nullable();
            $table->string('ville_demarrage')->nullable();
            $table->date('date_demarrage')->nullable();
            $table->double('note')->nullable();
            $table->unsignedBigInteger('status')->default(0);
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
        Schema::dropIfExists('destinations');
    }
}

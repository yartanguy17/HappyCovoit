<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations_clients', function (Blueprint $table) {
            $table->id();
            $table->date('date_reservation')->nullable();
            $table->date('date_depart')->nullable();
            $table->unsignedBigInteger('status_reservation')->default(0);
            $table->unsignedBigInteger('status_siege')->default(0);
            $table->unsignedBigInteger('client_id');
            $table->integer('nbre_places');
            $table->double('prix_total');
            $table->string('facture')->nullable();
            $table->string('reference')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('ligne_destination_id')->nullable(0);
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('destinations_compagnie');
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
        Schema::dropIfExists('reservations_clients');
    }
}

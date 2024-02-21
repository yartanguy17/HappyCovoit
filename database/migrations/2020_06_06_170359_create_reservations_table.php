<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date_reservation')->nullable();
            $table->date('date_depart')->nullable();
            $table->integer('nbre_places');
            $table->double('prix_total');
            $table->double('prix_total_commission');
            $table->integer('nbre_places_annules')->default(0);
            $table->unsignedBigInteger('status_reservation')->default(0);
            $table->unsignedBigInteger('status_siege')->default(0);
            $table->unsignedBigInteger('type_destination')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('is_signal')->default(0);
            $table->unsignedBigInteger('note')->default(0);
            $table->unsignedBigInteger('ligne_destination_id')->nullable(0);
            $table->string('facture')->nullable();
            $table->string('reference')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('destination_id');
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
        Schema::dropIfExists('reservations');
    }
}

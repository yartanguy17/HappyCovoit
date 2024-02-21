<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsSiegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations_sieges', function (Blueprint $table) {
            $table->id('id');
            $table->string('numero');
            $table->unsignedBigInteger('type_reservation')->default(1);
            $table->unsignedbigInteger('reservation_id')->nullable();
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
        Schema::dropIfExists('reservations_sieges');
    }
}

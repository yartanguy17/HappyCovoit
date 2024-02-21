<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('id');
            $table->string('identifier');
            $table->string('tx_reference')->nullable();
            $table->double('amount');
            $table->unsignedbigInteger('reservation_id')->nullable();
            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->boolean('status')->nullable()->default(0);
            $table->boolean('type')->nullable();
            $table->text('token')->nullable();
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
        Schema::dropIfExists('paiements');
    }
}

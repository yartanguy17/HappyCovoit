<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLignesDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lignes_destinations', function (Blueprint $table) {
            $table->id();
            $table->string('pays_destination')->nullable();
            $table->string('ville_destination')->nullable();
            $table->double('prix_unitaire');
            $table->unsignedBigInteger('status')->default(1);
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
        Schema::dropIfExists('lignes_destinations');
    }
}

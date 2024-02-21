<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Souscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('souscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('validite')->nullable();
            $table->date('expiration')->nullable();
            $table->date('date_souscription')->nullable();
            $table->double('prix')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('facture')->nullable();
            $table->string('reference')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('type')->default(1)->nullable();
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
        Schema::dropIfExists('souscriptions');
    }
}

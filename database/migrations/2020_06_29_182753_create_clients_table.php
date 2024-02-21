<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('telephone')->nullable();
            $table->string('nom')->nullable();
            $table->string('indicatif')->nullable();
            $table->string('prenoms')->nullable();
            $table->string('sexe')->nullable();
            $table->unsignedBigInteger('status')->default(1);
            $table->unsignedBigInteger('compagnie_id');
            $table->foreign('compagnie_id')->references('id')->on('users');
            $table->rememberToken();
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
        Schema::dropIfExists('clients');
    }
}

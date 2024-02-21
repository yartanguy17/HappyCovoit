<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsSouscriptionsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements_souscriptions', function (Blueprint $table) {
            $table->id('id');
            $table->string('identifier');
            $table->string('tx_reference')->nullable();
            $table->double('amount');
            $table->unsignedbigInteger('souscription_id')->nullable();
            $table->foreign('souscription_id')->references('id')->on('souscriptions');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_admin', function (Blueprint $table) {
            $table->id();
            $table->text('contenu');
            $table->unsignedbigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedbigInteger('status')->nullable()->default(0);
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
        Schema::dropIfExists('messages_admin');
    }
}

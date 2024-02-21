<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('telephone')->nullable();
            $table->string('indicatif')->nullable();
            $table->string('pseudo')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('code_inscription')->nullable();
            $table->string('token')->nullable();
            $table->unsignedBigInteger('status')->default(0);
            $table->unsignedBigInteger('type_user');
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
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sede_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('sede_id');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('sede_id')->references('id')->on('sedes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sede_user');
    }
}

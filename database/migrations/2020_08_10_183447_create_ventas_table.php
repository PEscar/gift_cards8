<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->nullable()->comment('id en fuente. i.e. order_id TiendaNube');
            $table->dateTime('date');
            $table->smallInteger('source_id')->comment('0: tiendanube. 1: intranet');
            $table->smallInteger('pagada')->comment('0: sin pagar. 1: pagado');
            $table->dateTime('fecha_pago')->nullable();
            $table->foreignId('vendedor_id')->nullable()->comment('id de usuario que realizo la venta manual');
            $table->foreignId('entrega_id')->nullable()->comment('id de usuario que realizo la entrega');
            $table->string('client_email')->nullable()->comment('email cliente');
            $table->text('comentario')->nullable();

            $table->timestamps();
            $table->foreign('vendedor_id')->references('id')->on('users');
            $table->foreign('entrega_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id');
            $table->string('sku')->comment('codigo de producto');
            $table->string('descripcion')->nullable()->comment('descripción del producto');
            $table->smallInteger('tipo_producto')->comment('1: gift card, 2: prod. normal.');
            $table->date('fecha_vencimiento')->nullable()->comment('!= null para gift cards');

            $table->dateTime('fecha_asignacion')->nullable()->comment('!= null para gift cards asignadas');
            $table->foreignId('asignacion_id')->nullable()->comment('id user que asigno la gc');

            $table->dateTime('fecha_consumicion')->nullable()->comment('!= null para gift cards consumidas');
            $table->foreignId('consumicion_id')->nullable()->comment('id user que consumio la gc');

            $table->smallInteger('cantidad');
            $table->string('codigo_gift_card')->nullable();
            $table->string('nro_mesa')->nullable()->comment('nro de mesa donde se sirve');
            $table->foreignId('sede_id')->nullable()->comment('id de sede donde se entrego la gc');

            $table->timestamps();

            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->foreign('asignacion_id')->references('id')->on('users');
            $table->foreign('consumicion_id')->references('id')->on('users');
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
        Schema::dropIfExists('venta_producto');
    }
}

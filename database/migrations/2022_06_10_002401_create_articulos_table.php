<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',15)->nullable();
            $table->string('nombre',100);
            $table->text('descripcion');
            $table->string('tipo',100);
            $table->decimal('precio');
            $table->string('existencia');
            $table->string('estado',1)->default('D');
            $table->integer('categoria_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla categorias
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->integer('color_id')->unsigned();
            //definiendo la columna anterior como llave foranea con la tabla colores
            $table->foreign('color_id')->references('id')->on('colores');
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
        Schema::dropIfExists('articulos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Decimal;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creaciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',15)->nullable();
            $table->string('estado',1)->default('D');
            $table->foreignId('categoria_id')
            ->nullable()
            ->constrained('categorias')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->string('talla');
            $table->foreignId('color_id')
            ->nullable()
            ->constrained('colores')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->text('descripcion');
            $table->text('cantidad',);
            
            $table->decimal('precio',5,2);
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
        Schema::dropIfExists('creaciones');
    }
};

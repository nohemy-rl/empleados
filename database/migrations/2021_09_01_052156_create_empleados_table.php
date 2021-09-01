<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('departamento_id');
            $table->string('nombre');
            $table->string('paterno');
            $table->string('materno');
            $table->date('fecha_nacimiento');
            $table->string('correo_electronico');
            $table->string('genero',20)->nullable();
            $table->string('telefono',20)->nullable();
            $table->string('celular',20)->nullable();
            $table->date('fecha_ingreso');
            $table->unsignedBigInteger('usuario_creacion_id')->nullable();
            $table->unsignedBigInteger('usuario_actualizacion_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('usuario_creacion_id')->references('id')->on('users');
            $table->foreign('usuario_actualizacion_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}

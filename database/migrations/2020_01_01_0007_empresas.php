<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Empresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('codigo');
            $table->string('razao_social',250);
            $table->string('nome_fantasia');
            $table->string('cnpj',19)->nullable()->unique();
            $table->string('cpf',15)->unique();
            $table->string('tipo',10);
            $table->string('logo',250)->nullable();
            $table->integer('endereco_id')->unsigned();
            $table->foreign('endereco_id')->references('id')->on('enderecos');
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
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
        //
    }
}

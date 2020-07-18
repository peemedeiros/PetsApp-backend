<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableServicosAgendamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicos_agendamentos', function (Blueprint $table) {

            $table->unsignedBigInteger('agendamento_servico_id');
            $table->unsignedBigInteger('servico_id');

            $table->foreign('agendamento_servico_id')->references('id')->on('agendamento_servico');
            $table->foreign('servico_id')->references('id')->on('servicos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicos_agendamentos');
    }
}

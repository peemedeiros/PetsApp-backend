<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentoServicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamento_servico', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('animal_id');
            $table->unsignedBigInteger('endereco_id');

            $table->boolean('transporte');
            $table->decimal('valor_transporte', 8, 2)->default(0);

            $table->decimal('valor_total', 8, 2);
            $table->boolean('status')->default(0);
            $table->date('data_agendamento');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('empresa_id')->references('id')->on('empresa');
            $table->foreign('animal_id')->references('id')->on('animals');
            $table->foreign('endereco_id')->references('id')->on('endereco_clientes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamento_servico');
    }
}

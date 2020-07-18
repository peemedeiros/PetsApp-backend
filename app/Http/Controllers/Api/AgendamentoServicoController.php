<?php

namespace App\Http\Controllers\Api;

use App\AgendamentoServico;
use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendamentoServicoController extends Controller
{
    public function __construct(AgendamentoServico $agendamentoServico)
    {
        $this->agendamentoServico = $agendamentoServico;
    }

    public function index()
    {
        $agendamentosServicos = $this->agendamentoServico->with('user', 'animal', 'servico')->paginate(10);
        return response()->json($agendamentosServicos, 200);
    }


    public function store(Request $request)
    {
        $data = $request->all();

        var_dump($data['servicos']);

        try{
            $data['user_id'] = auth('api')->user()->id;

            $agendamentoServico = $this->agendamentoServico->create($data);

//            $servicosArr = explode(',', $data['servicos']);
//
//            var_dump("AQUIIII ".$servicosArr);

            if(isset($data['servicos']) && count($data['servicos'])){
                $agendamentoServico->servico()->sync($data['servicos']);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Agendamento enviado com sucesso!'
                ]
            ], 201);


        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);

        }
    }

    public function show($id)
    {
        try{
            $agendamentoServico = auth('api')->user()->agendamentoServicos()->with('user','animal','servico','endereco')->findOrFail($id);

            return response()->json([
                'data' => $agendamentoServico
            ], 200);
        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);

        }
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

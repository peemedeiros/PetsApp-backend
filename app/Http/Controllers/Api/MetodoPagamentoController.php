<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\MetodoPagamento;
use Illuminate\Http\Request;

class MetodoPagamentoController extends Controller
{
    private $metodoPagamento;

    public function __construct( MetodoPagamento $metodoPagamento)
    {
        $this->metodoPagamento = $metodoPagamento;
    }

    public function index()
    {
        $metodosPagamento = $this->metodoPagamento->paginate(10);

        return response()->json($metodosPagamento, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try{
            $metodoPagamento = $this->metodoPagamento->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Método de pagamento cadastrado com sucesso!',
                    'metodo' => $metodoPagamento
                ]
            ], 201);
        }catch (\Exception $e){

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);

        }
    }

    public function show($id)
    {
        //
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

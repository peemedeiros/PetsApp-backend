<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\EnderecoCliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnderecoClienteController extends Controller
{
    public function __construct(EnderecoCliente $endereco)
    {
        $this->endereco = $endereco;
    }

    public function index()
    {
        $enderecos = $this->endereco->paginate(10);
        return response()->json($enderecos, 200);
    }


    public function store(Request $request)
    {
        $data = $request->all();

        try{
            $data['user_id'] = auth('api')->user()->id;

            $endereco = $this->endereco->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Endereco cadastrado com sucesso!',
                    'endereco' => $endereco
                ]
            ], 201);

        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function show($id)
    {
        try{
            $endereco = auth('api')->user()->endereco()->findOrFail($id);

            return response()->json([
                'data' => [
                    'endereco' => $endereco
                ]
            ], 200);

        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try {
            $endereco = auth('api')->user()->endereco()->findOrFail($id);
            $endereco->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Endereço atualizado com sucesso!',
                    'animal' => $endereco
                ]
            ]);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        try{
            $endereco = auth('api')->user()->endereco()->findOrFail($id);
            $endereco->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Endereço deletado com sucesso!'
                ]
            ], 204);

        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }
}

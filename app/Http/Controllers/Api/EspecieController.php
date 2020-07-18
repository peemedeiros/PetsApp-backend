<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Especie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EspecieController extends Controller
{

    public function __construct(Especie $especie)
    {
        $this->especie = $especie;
    }

    public function index()
    {
        $especies = $this->especie->paginate(10);
        return response()->json($especies, 200);
    }


    public function store(Request $request)
    {
        $data = $request->all();
        try{
            $this->especie->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Espécie cadastrada com sucesso !'
                ]
            ], 201);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function show($id)
    {
        try{

            $especie = $this->especie->findOrFail($id);

            return response()->json([
                'data' => $especie
            ], 200);

        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try{

            $especie = $this->especie->findOrFail($id);
            $especie->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Espécie atualizada com sucesso !'
                ]
            ], 200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try{
            $especie = $this->especie->findOrFail($id);
            $especie->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Espécie atualizada com sucesso !'
                ]
            ], 204);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}

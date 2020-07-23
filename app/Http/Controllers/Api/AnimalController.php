<?php

namespace App\Http\Controllers\Api;

use App\Animal;
use App\Api\ApiMessages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnimalController extends Controller
{

    public function __construct(Animal $animal)
    {
        $this->animal = $animal;
    }

    public function index()
    {
        $animais = auth('api')->user()->animal()->with('especie')->paginate(10);
        return response()->json($animais, 200);
    }

    public function all($id)
    {
        $animais = $this->animal->where('user_id', '=', $id)->get();
        return response()->json($animais, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try{
            $data['user_id'] = auth('api')->user()->id;

            $animal = $this->animal->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Animal cadastrado com sucesso!',
                    'animal' => $animal
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
            $animal = auth('api')->user()->animal()->findOrFail($id);

            return response()->json([
                'data' => [
                    'animal' => $animal
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

            $animal = auth('api')->user()->animal()->findOrFail($id);
            $animal->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'animal atualizado com sucesso!',
                    'animal' => $animal
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
            $animal = auth('api')->user()->animal()->findOrFail($id);
            $animal->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Animado deletado com sucesso!'
                ]
            ], 204);

        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Categoria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    private $categoria;

    public function __construct(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }

    public function index()
    {
        $caterogias = $this->categoria->paginate('10');
        return response()->json($caterogias, 200);
    }



    public function store(Request $request)
    {
        $data =$request->all();
        try{
            $categoria = $this->categoria->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Categoria cadastrada com sucesso!'
                ]
            ], 201);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function show($id)
    {
        try{

            $categoria = $this->categoria->findOrFail($id);

            return response()->json([
                'data' => $categoria
            ], 200);

        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();

        try{
            $categoria = $this->categoria->findOrFail($id);
            $categoria->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Categoria atualizada com sucesso!'
                ]
            ]);

        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try{
            $categoria = $this->categoria->findOrFail($id);
            $categoria->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Categoria excluida'
                ]
            ], 204);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function empresa($id)
    {
        try{
            $categoria = $this->categoria->findOrFail($id);

            return response()->json([
                'data' => $categoria->empresa
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Subcategoria;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{

    private $subcategoria;

    public function __construct(Subcategoria $subcategoria)
    {
        $this->subcategoria = $subcategoria;
    }

    public function index()
    {
        $subcategorias = $this->subcategoria->paginate(10);

        return response()->json($subcategorias, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try{
            $subcategoria = $this->subcategoria->create($data);

            if(isset($data['categorias']) && count($data['categorias'])){
                $subcategoria->categoria()->sync($data['categorias']);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Sub-categoria cadastrada com sucesso!'
                ]
            ], 201);

        }catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function show($id)
    {
       try{
           $subcategoria = $this->subcategoria->findOrFail($id);

           return response()->json([
               'data' => $subcategoria],
           200);

       }catch (\Exception $e){
           $message = new ApiMessages($e->getMessage());
           return response()->json($message->getMessage(), 401);
       }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try{

            $subcategoria = $this->subcategoria->findOrFail($id);
            $subcategoria->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Sub-categoria cadastrada com sucesso!'
                ]
            ], 200);

        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try{
            $subcategoria = $this->subcategoria->findOrFail($id);

            $subcategoria->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Sub-categoria cadastrada com sucesso!'
                ]
            ], 204);
        } catch (\Exception $e) {

        }
    }
}

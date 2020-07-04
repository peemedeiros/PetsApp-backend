<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{

    private $servico;

    public function __construct(Servico $servico)
    {
        $this->servico = $servico;
    }

    public function index()
    {
        $servicos = $this->servico->paginate('10');
        return response()->json($servicos, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $images = $request->file();
        try{

            $servico = $this->servico->create($data);

            if($images){

                echo('passsooouuuuuu');

                $imageUploaded = [];

                if(!is_array($images)) $array = [$images];
                else{
                    $array = $images;
                }

                foreach($array as $image){
                    $path = $image->store('images', 'public');
                    $imageUploaded[] = ['foto' => $path, 'is_thumb' => false];
                }

                $servico->foto()->createMany($imageUploaded);

            }

            return response()->json([
                'data'=>[
                    'msg' => 'Serviço cadastrado com sucesso !',
                    'servico' => $servico
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
            $servico = $this->servico->with('foto')->findOrFail($id);

            return response()->json([
                'data'=>$servico]
            , 201);

        }catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try {
            $servico = $this->servico->findOrFail($id);
            $servico->update($data);

            return response()->json([
                'data'=>[
                    'msg' => 'Serviço atualizado com sucesso !',
                    'servico' => $servico
                ]
            ], 201);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try{

            $servico = $this->servico->findOrFail($id);
            $servico->delete($id);

            return response()->json([
                'data'=>[
                    'msg' => 'Serviço deletada com sucesso !'
                ]
            ], 204);

        }catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}

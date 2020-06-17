<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Empresa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    private $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function index()
    {
        $empresas = auth('api')->user()->empresa();

        return response()->json($empresas->paginate(10), 200);
    }

    public function all(){
        $empresas = $this->empresa->paginate(10);
        return response()->json( $empresas, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        Validator::make($data, [
            'razao_social'      => ['required', 'string', 'max:100'],
            'nome_fantasia'     => ['required', 'string', 'max:100'],
            'cnpj'              => ['required', 'max:50','string'],
            'telefone_empresa'  => ['required', 'string', 'max:20'],
            'cep'               => ['required', 'string', 'max:10'],
            'logradouro'        => ['required', 'string'],
            'bairro'            => ['required', 'string'],
            'cidade'            => ['required', 'string'],
            'uf'                => ['required', 'string'],
            'numero'            => ['required', 'numeric']
        ])->validate();

        try {
            $data['user_id'] = auth('api')->user()->id;

            $empresa = $this->empresa->create($data);

            if($images){

                $imageUploaded = [];

                foreach($images as $image){
                    $path = $image->store('images', 'public');
                    $imageUploaded[] = ['foto' => $path, 'is_logo' => true];
                }

                $empresa->foto()->createMany($imageUploaded);

            }

            return response()->json([
                'data' => [
                    'msg' => 'Empresa cadastrada com sucesso!'
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
            $empresa = auth('api')->user()->empresa()->with('user', 'foto')->findOrFail($id);

            return response()->json([
                'data' => $empresa
            ], 200);
        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);

        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $images = $request->file('images');

        Validator::make($data, [
            'razao_social'      => ['string', 'max:100'],
            'nome_fantasia'     => ['string', 'max:100'],
            'cnpj'              => ['max:50','string'],
            'telefone_empresa'  => ['string', 'max:20'],
            'cep'               => ['string', 'max:10'],
            'logradouro'        => ['string'],
            'bairro'            => ['string'],
            'cidade'            => ['string'],
            'uf'                => ['string'],
            'numero'            => ['numeric']
        ])->validate();

        try {

            $empresa = auth('api')->user()->empresa()->findOrFail($id);
            $empresa->update($data);

            if($images){

                $imageUploaded = [];

                foreach($images as $image){
                    $path = $image->store('images', 'public');
                    $imageUploaded[] = ['foto' => $path, 'is_logo' => true];
                }

                $empresa->foto()->createMany($imageUploaded);

            }

            return response()->json([
                'data' => [
                    'msg' => 'Empresa atualizada com sucesso!'
                ]
            ], 201);
        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);

        }
    }

    public function destroy($id)
    {
       try{

            $empresa = auth('api')->user()->empresa()->findOrFail($id);
            $empresa->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Empresa deletada com sucesso!'
                ]
            ], 201);

        }catch(\Exception $e){

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);

        }
    }
}

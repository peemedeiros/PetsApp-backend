<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->paginate(10);

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'nome',
            'email',
            'password',
            'password_confirmation',
            'celular',
            'tipo_cadastro',
        ]);

        Validator::make($data, [
            'nome' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'celular' => ['required', 'string', 'max:20'],
        ])->validate();

        try{
            $data['password'] =bcrypt($data['password']);

            $this->user->create($data);

            return  response()->json([
                'data' => [
                    'msg' => 'Usuário cadastrado com sucesso!',
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

            $user = $this->user->with('endereco')->findOrFail($id);

            if($id == auth('api')->id()){

                return response()->json([
                    'data' => $user
                ], 200);
            }

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();

        Validator::make($data, [
            'nome' => ['string', 'max:100'],
            'email' => ['string', 'email', 'max:200', 'unique:users'],
            'password' => ['string', 'min:8', 'confirmed'],
            'celular' => ['string', 'max:20'],
        ])->validate();

        if($request->has('password') && $request->get('password')){
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        try {

            $user = $this->user->findOrFail($id);

            if($id == auth('api')->id()){
                $user->update($data);

                return response()->json([
                    'data' => [
                        'msg' => 'Usuário atualizado com sucesso'
                    ]
                ], 200);
            } else {
                return response()->json([
                    'data' => [
                        'msg' => 'Voce nao tem permissao para alterar este usuario'
                    ]
                ], 401);
            }

        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }


    }

    public function destroy($id)
    {
        try{
            $user = $this->user->findOrFail($id);
            $user->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Usuario deletado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}

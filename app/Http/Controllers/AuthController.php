<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credenciais = $request->all(['email', 'password']); //[]

        //autenticação (email e senha)
        $token = auth('api')->attempt($credenciais);

        if($token) { //usuário autenticado com sucesso
            return response()->json(['token' => $token]);

        } else { //erro de usuário ou senha
            return response()->json(['erro' => 'Usuário ou senha inválido!'], 403);
        }
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Logout feito']);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json(['token' => $token]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}

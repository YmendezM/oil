<?php

namespace App\Http\Controllers\Tatuco;

use App\Acl\Src\Models\Role;
use App\Models\Tatuco\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    /**
     * metodo de inicio de sesion
     * @param Request $request
     * @return mensaje de inicio de sesion, datos incorrectos o inicio exitoso
     */
    public function login(Request $request)
    {
        // credenciales del login, aqui se cambian por los que esten en la bd
        $credenciales = $request->only('use_nic','password');


        try {
            $query = User::select('use_nic')
                ->where('use_act',true)
                ->where('sta_id',1)
                ->where('use_nic',$request->use_nic)
                ->first();
            //si el usuario esta bloqueado o eliminado
            if(!$query){
                return response()->json([
                    'message' => 'Datos Incorrectos. '
                ], 401);

            }
            //si no se inicia la sesion correctamente
           if(!$token = \JWTAuth::attempt($credenciales)){
                return response()->json([
                    'message' => 'Datos Incorrectos. '
                ], 401);

            }

            Log::info("Token Creado");
        }catch (JWTException $e){
            //devuelve el error
            Log::critical("Error, archivo del peo: {$e->getFile()}, linea del peo: {$e->getLine()}, el peo: {$e->getMessage()}");
            return response()->json([
                'message' => 'Error al intentar crear el token. Intente de nuevo'
            ], 500);
        }
        $user = \JWTAuth::toUser($token);
        $role = $user->getRoles();

        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => \JWTAuth::toUser($token),
            'roles'=> $role
        ], 200);
    }

    /**
     * metodo de cierre de sesion
     * @return respuesta de la consulta
     */
    public function logout()
    {
        try{
            //si el cierre de sesion se procesa envia el mensaje
            \JWTAuth::invalidate(\JWTAuth::getToken());
            return response()->json([
                'msj' => 'success logout exit.'
            ], 200);
            Log::info("Token invalidado satisfactoriamente");
        }catch (JWTException $e){
            //devuelve el error si lo hay
            Log::critical("Error, archivo del peo: {$e->getFile()}, linea del peo: {$e->getLine()}, el peo: {$e->getMessage()}, codigo del peo: {$e->getStatusCode()}");
            return response()->json([
                'msj' => 'Error al intentar olvidar token'
            ], 500);
        }


    }

    /**
     * funcion de validacion
     */
    public function validate()
    {
        try{
            if(!$user = \JWTAuth::parseToken()->authenticate())
                return response()->json([
                    'msj' => 'Usuario no Encontrado'
                ], 404);
        }catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            return response()->json([
                'msj' => 'Usuario no Encontrado'
            ], $e->getStatusCode());
        }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            return response()->json([
                'msj' => 'Token Invalido'
            ], $e->getStatusCode());
        }catch (\Tymon\JWTAuth\Exceptions\JWTException $e){
            return response()->json([
                'msj' => 'Token Inexistente'
            ], $e->getStatusCode());
        }
        return response()->json([
            'status' => true,
            'user' => $user
        ], 200);
    }

}

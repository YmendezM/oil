<?php
namespace App\Http\Services\Tatuco;

use App\Models\Tatuco\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class UserService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'user';
        $this->model = new User();
        $this->namePlural = 'users';
    }

    /**
     * @return json con los registros
     */
    public function index(Request $request)
    {
        //consulto los permisos
        if (($this->checkPermission('index.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso para index.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para listar registros de este modulo');
        }
        $user = $this->currentUSer(); //consulto usuario logueado
        $query = User::from('users as u')
            ->select('u.use_dni','u.use_nam','u.use_lna','u.use_nic','u.email','u.sta_id','s.sta_des',
                'ru.role_id','ru.user_id', 'r.name')
            ->join('status as s','s.sta_id','u.sta_id')
            ->join('role_user as ru','ru.user_id','u.id')
            ->join('roles as r','r.id','ru.role_id')
            ->where('u.use_act',true)
            ->where('u.acc_id',$user->acc_id)
            ->get();

        return response()->json($query, 200);
    }

    /**
     * metodo que retorna el registro que coincide con el filtrado de busqueda
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_fk = valor de la llave primaria por la que va a consultar
     * @param $g_status = nombre del campo status
     * @return json con el registro que coincida con el valor de la llave primaria y el status sea true
     */
    public function show($g_namePrimaryKey, $x_fk, $g_status)
    {
        try{
            //consulto los permisos
            if (($this->checkPermission('show.'.$this->name)) == false ) {
                return  response()->json(["message" => "no tienes permiso show.$this->name"], 403)
                    ->setStatusCode(403, 'no tienes permiso para ver registros de este modulo');
            }
            $user = $this->currentUSer(); //consulto usuario logueado
            $query = User::from('users as u')
                ->select('u.use_dni','u.use_nam','u.use_lna','u.use_nic','u.email','u.sta_id','s.sta_des',
                    'ru.role_id','ru.user_id', 'r.name')
                ->join('status as s','s.sta_id','u.sta_id')
                ->join('role_user as ru','ru.user_id','u.id')
                ->join('roles as r','r.id','ru.role_id')
                ->where('u.use_act',true)
                ->where('u.id',$x_fk)
                ->where('u.acc_id',$user->acc_id)
                ->first();
            if(!$query) //si no consigue nada delvuelve 404
            {
                return response()->json(['message'=>$this->name. ' no existe'], 404);
            }
            return response()->json([
                'status'=>true,
                'message'=> $this->name. ' Encontrado',
                $this->name => $query,
            ], 200);

            //si ocurre alguna exception la devuelve
        }catch (\Exception $e){
            Log::critical("Error, archivo del error: {$e->getFile()}, linea del error: {$e->getLine()}, el peo: {$e->getMessage()}, codigo del peo: {$e->getCode()}");
            return response()->json([
                "message"=>"Error de servidor",
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return json con la respuesta de guardado
     */
    public function store($request){
        //consulto los permisos
        if (($this->checkPermission('store.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso para store.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para crear registros de este modulo');
        }
        $pass = bcrypt($request->json(['password'])); //encripto la contraseña
        $request->merge(['password' => $pass]); //inserto en el $request
        $use_nic=$request->use_nic;
        $use_dni=$request->use_dni;
        //valido si datos del usuario esta registrado (dni, username)
        $nic = User::where("use_nic",$use_nic)
            ->first();
        if($nic){
            return  response()->json(["message" => "El username $use_nic ya existe en la base de datos"], 500)
                ->setStatusCode(500, 'El username '.$use_nic. ' ya existe en la base de datos');
        }

        $dni = User::where("use_dni","=",$use_dni)
            ->first();
        if($dni){
            return  response()->json(["message" => "El DNI $use_dni ya existe en la base de datos"], 500)
                ->setStatusCode(500, 'El DNI '.$use_dni. ' ya existe en la base de datos');
        }
        if ($this->object = User::create($request->all())) {
            $id = $this->object->id;
            $idR = $request->json(['role_id']);
            $user = User::find($id);
            $user->assignRole($idR);
            $user = User::find($id);
            $rolesAsigned = $user->getRoles();
            if ($rolesAsigned) {
                return  response()->json(["message" => "Registro guardado con exito"], 200)
                    ->setStatusCode(200, 'Registro guardado con exito');
            } else {
                DB::delete("delete from users where id = '$id' ");
                return  response()->json(["message" => "Ocurrio un error al guardar"], 500)
                    ->setStatusCode(500, 'Ocurrio un error al guardar');
            }
        }
    }

    /**
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @param Request $request
     * @return json con la respuesta de la actualizacion
     */
    public function update($g_namePrimaryKey, $x_pk, $g_status, Request $request)
    {
        //consulto los permisos
        if (($this->checkPermission('update.'.$this->name)) == false ) {
            return  response()->json(["message" => "no tienes permiso update.$this->name"], 403)
                ->setStatusCode(403, 'no tienes permiso para modificar registros de este modulo');
        }
        //si se va a modificar el rol del usuario
         if($request->json(['role_id'])){
             $this->object = $this->findTatuco($g_namePrimaryKey, $x_pk, $g_status);
            $id= $this->object->id;
            $role = $request->role_id;
            DB::update("update role_user set role_id = '$role' where user_id ='$id' ");
        }
        //si es modificacion de contraseña
        if($request->json(['password'])){
            $pass = $request->get('password');
            $new = $request->get('newpassword');
            $confirm = $request->get('confirmPassword');
            //consulto si la contraseña anterior es correcta
            $user = User::select('password')
                ->where('use_dni',$x_pk)
                ->first();
            if(Hash::check($pass, $user->password)){
               if($new == $confirm){
                   try{
                       $newPass = bcrypt($new);
                       $update = $this->findTatuco($g_namePrimaryKey, $x_pk, $g_status);
                       $update->password = $newPass;

                       $update->update();
                       return  response()->json(["message" => "Modificacion de contraseña realizada correctamente"], 201)
                           ->setStatusCode(201, 'Modificacion de contrase&ntilde;a realizada correctamente');
                   }catch (\Exception $e){
                       return  response()->json(["message" => "Ocurrio un error al modificar la contraseña"], 500)
                           ->setStatusCode(500, 'Ocurrio un error al modificar la contrase&ntilde;a');
                   }

               }else{
                   return  response()->json(["message" => "Las contraseñas no coinciden"], 500)
                       ->setStatusCode(500, 'Las contrase&ntilde;as no coinciden');
               }
            }else{
                return  response()->json(["message" => "La contraseña anterior es incorrecta"], 500)
                    ->setStatusCode(500, 'La contrase&ntilde;a anterior es incorrecta');
            }
        }
        //llamo a tatuco service
        return $this->_update($g_namePrimaryKey, $x_pk, $g_status, $request);
    }

    /**
     * metodo que asigna un rol a un usuario
     * @param $idUser = id de usuario
     * @param $idRole = id del rol
     * @return json con la respuesta de la asignacion
     */
    public function assignedRole($x_idUser, $x_idRole)
    {
        try{

            $user=User::find($x_idUser);
            $user->assignRole($x_idRole);

            $user=User::find($x_idUser);
            $rolesAsigned=$user->getRoles();

            if($rolesAsigned){
                Log::info('Rol Asignado');
                return response()->json([
                    'status'=> true,
                    'message'=> 'role asignado satisfactoriamente. ',
                    'rolesAsigned' => $rolesAsigned
                ], 200);
            }
        }catch (\Exception $e){
            Log::critical("Error, archivo del peo: {$e->getFile()}, linea del peo: {$e->getLine()}, el peo: {$e->getMessage()}");
            return response()->json(["msj"=>"Error de servidor"], 500);
        }
    }

    /**
     * metodo que revoca el rol a un usuario
     * @param $idUser = id de usuario
     * @param $idRole = id del rol
     * @return json con la respuesta de la revocacion
     */
    public function revokeRole($x_idUser, $x_idRole)
    {
        try{
            $user=User::find($x_idUser);
            if ($user->revokeRole($x_idRole)){
                $rolesAsigned=$user->getRoles();
                return response()->json([
                    'status' => true,
                    'msj' => 'Role revocado Satisfactoriamente',
                    'rolesAsigned' => $rolesAsigned
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'msj' => 'Error al revocar el rol',
                ], 500);
            }
        }catch(\Exception $e){
            Log::critical("Error, archivo del peo: {$e->getFile()}, linea del peo: {$e->getLine()}, el peo: {$e->getMessage()}");
            return response()->json(["msj"=>"Error de servidor"], 500);
        }
    }
}

<?php
namespace app\Http\Services\Gasolinera;

use App\Http\Services\Tatuco\TatucoService;
use App\Models\Gasolinera\Audit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AuditService extends TatucoService
{
    public function __construct()
    {
        $this->name = 'audit';
        $this->model = new Audit();
        $this->namePlural = 'audits';
    }

    /**
     * @param Request $request
     * @return _store de tatucoService
     */
    public function store(Request $request)
    {
        return $this->_store($request);
    }

    /**
     * @param $g_namePrimaryKey = nombre de la llave primaria
     * @param $x_pk = valor de la llave primaria
     * @param $g_status = nombre del campo status
     * @param Request $request
     * @return _update de tatucoService
     */
    public function update($g_namePrimaryKey, $x_pk, $g_status, Request $request)
    {
        return $this->_update($g_namePrimaryKey, $x_pk, $g_status, $request);
    }

    /**
     * @param $request = request con la data que se va a modificar el registro
     * @param $x_data_old = data anterior al registro
     * @param $x_action = que accion es = agregar, modificar, eliminar
     * @param $x_module = que modulo es, dispensar, vehiculos, usuarios
     */
    public function insertAudit($request, $x_data_old, $x_pk, $x_action, $x_module)
    {
        //consulto el usuario logueado
        $user = $this->currentUSer();
        //convierto $x_data_old al formato que necesito
        $x_data_old = str_replace('[', '', $x_data_old);//quito el corchete [
        $x_data_old = str_replace('{', "'" , $x_data_old);//quito la llave {
        $x_data_old = str_replace('}', "'", $x_data_old);//quito la llave }
        $x_data_old = str_replace(']', '', $x_data_old);//quito el corchete ]
        $x_data_old = str_replace(':', '=>', $x_data_old);//cambio : por =>

        //consulto la ip
        $ip = $request->ip();

        //convierto $data_new al formato que necesito
        $data_new = json_encode($request->all());
        $data_new = str_replace(':', '=>', $data_new);//cambio : por =>
        $data_new = str_replace('{', '', $data_new);//quito la llave {
        $data_new = str_replace('}', '', $data_new);//quito la llave }

        //saco la fecha actual
        $now = Carbon::now()->format('Y-m-d h:i:s');

        //hago el insert
        DB::insert("insert into audits (aud_pk, aud_use, aud_act, aud_mod, aud_ip, acc_id, created_at, aud_dbe, aud_dnew) VALUES  
        ('$x_pk','$user->use_nic', '$x_action', '$x_module', '$ip', $user->acc_id, '$now', $x_data_old, '$data_new') ");
    }
}
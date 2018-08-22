<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'veh_id' => 'required|unique',
            'veh_pla' => 'required|unique',
            'veh_com' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'veh_id' => 'El campo ID del vehículo es requerido',
            'veh_pla' => 'El campo placa del vehículo es requerido',
            'veh_com' => 'El campo consumo de combustible es requerido'
        ];
    }
}

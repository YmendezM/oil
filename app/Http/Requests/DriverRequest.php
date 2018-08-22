<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
            'dri_dni' => 'required|unique|min:6',
            'dri_nam' => 'min:2',
            'dri_lna' => 'min:2',
            'dri_mai' => 'email',
            'dri_pho' => 'numeric',
            'dri_lic' => 'unique',
            'dri_com' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'dri_dni' => 'El campo DNI es requerido y mìnimo (6) caracteres',
            'dri_lic' => 'El campo licencia es requerido y debe ser unico',
            'dri_com' => 'El campo consumo de combustible es requerido'
        ];
    }
}

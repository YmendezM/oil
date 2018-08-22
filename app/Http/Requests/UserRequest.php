<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'use_dni' => 'required|unique|min:6',
            'use_nam' => 'required|min:2',
            'use_lna' => 'min:2',
            'email' => 'required|email',
            'use_nic' => 'required|min:6',
            'password' => 'required|string|min:8'
        ];
    }

    public function attributes()
    {
        return [
            'use_dni' => 'El campo DNI es requerido y mìnimo (6) caracteres',
            'use_nam' => 'El campo nombre es requerido y mìnimo (2) caracteres',
            'use_lna' => 'min:2',
            'email' => 'El campo email es requerido',
            'use_nic' => 'El campo nombre de usuario es requerido y mìnimo (6) caracteres',
            'password' => 'El campo contraseña es requerido'
        ];
    }
}

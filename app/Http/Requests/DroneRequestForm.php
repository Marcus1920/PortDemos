<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DroneRequestForm extends Request
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
            'department' => 'required',
            'drone_type_id' => 'required',
            'sub_drone_type_id' => 'required',
            'comment' => 'required'

        ];
    }

}

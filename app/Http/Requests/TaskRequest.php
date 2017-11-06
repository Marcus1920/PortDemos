<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TaskRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'task_category_id' => 'required|not_in:0',
            'priority_id'      => 'required|not_in:0',
            'title'            => 'required',
            'task_user_id'     => 'required'
        ];
    }
}

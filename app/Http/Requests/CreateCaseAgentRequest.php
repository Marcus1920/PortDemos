<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCaseAgentRequest extends Request
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

           'case_type'              =>'required|not_in:0',
//           'case_sub_type'          =>'required|not_in:0',
'saps_station'=>'required',
           'cellphone'                  =>'required',
           'name'                       =>'required|alpha',
           'surname'                    =>'required|alpha',
           'company'                    =>'required',
           'description'                =>'required',
           'client_reference_number'    =>'required',
           'saps_case_number'           =>'required',
           'saps_case_number'           =>'required',
        //   'rate_value'                 =>'required',
           'investigation_cell'         =>'required',
           'investigation_email'        =>'email',
           'investigation_note'         =>'required',






            
        ];
    }
}

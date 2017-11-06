<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PoiRequest extends Request
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

          //  'name'                  =>'required',
            //'surname'               =>'required',
//            'gender'                =>'required|not_in:0',
//            'weight'                =>'required|numeric',
//            'email'                 =>'email',
//            //'nationality'           =>'required|not_in:0',
//            //'document_type'         =>'required|not_in:0'
//           /* 'id_number'             =>'digits:13',*/
//          'language'              =>'required|not_in:0',
//          'position'              =>'required|not_in:0',
//            'poi_profile_file'      =>'mimes:jpeg',
           // 'profile_pic_note'     =>'required',
//            'tax_number'          =>'required|numeric',

//            'has_driver_licence'    =>'required|not_in:0'
            
        ];
    }


    public  function messages()
    {
        return [

            'profile_pic_note.required'   =>"note must be not empty",
        ];     }
}

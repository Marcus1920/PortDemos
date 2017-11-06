<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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

    public function validateMobile($attribute, $value, $parameters)
    {
        // Mobile number can start with plus sign and should start with number
        // and can have minus sign and should be between 9 to 12 character long.
        return preg_match("/^\+?\d[0-9-]{9,12}/", $value);
    }
//'description'=>'required|regex:/^[A-Za-z \t]*$/i|min:3|unique:courses',
    public function rules()
    {
        return [
            'role'              => 'required|not_in:0',
            'title'             => 'required|not_in:0',
            'name'              => 'required|alpha|different:surname',
            'surname'           => 'required|alpha|different:name',
            'language'          => 'required|not_in:0',
            'gender'            => 'required|not_in:0',
            'department'        => 'required|not_in:0',
            'position'          => 'required|not_in:0',
            'affiliation'       => 'required|not_in:0',

            'cellphone'         => 'required',
            'email'             => 'required|email|unique:users,email',

            'id_number'         => 'required|unique:users,id_number|digits:13',
            'company'           => 'required',
            'alt_email'        => 'different:email|unique:users,email',
        ];


    }

    public function messages()
    {
        return [
            'title.not_in'               => 'Please select title',
            'language.not_in'            => 'Please select language',
            'role.not_in'                => 'Please select role',
            'gender.not_in'              => 'Please select gender',
            'department.not_in'          => 'Please select department',
            'position.not_in'            => 'Please select position',
            'affiliation.not_in'         => 'Please select affilitiation',

            'id_number.required'        =>  'Please enter 13 digits ID Number',
            'name.required'             =>  'Please enter name',
            'surname.required'          =>  'Please enter surname',
            'cellphone.required'        =>  'Please enter cell phone number',
            'company.required'          =>  'Please enter company name',
            'email.required'            =>  'Please enter email address',

            'email.email'               =>  'This email address is not valid',
            'alt_email.different'       =>  'Alternative and email address must be different',

        ];


    }
}
<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class DocumentRepositoryRequest extends Request
{

    public function authorize()
    {
        return true;
    }
    //mime:

    public function rules()
    {
           //$request = new Request(); $url = Request::url(); 
         
           //echo Request::segment(1);    echo $this->get('folder_id'); die;
   
           if(Request::segment(1)=='saveDocumentfile')
           {                
                return [
                    'upload_doc'     =>'required|mimes:jpeg,png,jpg,gif,svg,pdf,DOC,doc,txt,csv,xls,DOCX,XLSX,xlsx,docx',
                    'description'     =>'required',
                    'role' =>'required',
                ];

           }else{                
                return [
                    'name'     =>'required|unique:document_repositories,name,'.$this->get('folder_id'),
                    'description'     =>'required',
                    'role' =>'required',
                ];
           }              
    }

  /* public function messages()
    {
         return [
              'name.required' => 'Name is required.',              
              'description.required'='Description is required'
         ];
    }
*/
    

}

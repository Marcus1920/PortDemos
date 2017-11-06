<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\DocumentRepositoryRequest;
use App\DocumentRepository;
use App\DocumentImage;
use App\Http\Controllers\Controller;
use Input;
use File;
use DB;
use Image;
use App\services\DocumentRepoService;
use App\DocumentLog;

class DocumentRepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function index()
     {
           $DocumentRepository = DocumentRepository::select(array('id','name','created_at','description'));
   
          return \Datatables::of($DocumentRepository)
                            ->addColumn('actions','<a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchUpdateDepartmentModal({{$id}});" data-target=".modalEditDepartment">Edit</a>')->make(true);
     }



     public function documentLogIndex()
     {
        
            $DocumentLog = new DocumentLog();         

            $DocumentLogData = $DocumentLog->join('document_images', 'document_images.id', '=', 'document_logs.document_id')
            ->join('users', 'document_logs.user_id', '=', 'users.id')
            ->where('document_images.group_id',\Auth::user()->role)
            ->select('document_logs.id','document_logs.created_at','document_logs.document_path','document_logs.operation','users.name','users.surname','users.email','document_images.name as documentName')
            ->orderBy('document_logs.id','DESC')->get();

    
            return \Datatables::of($DocumentLogData)
                            ->addColumn('actions','<a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchUpdateDepartmentModal({{$id}});" data-target=".modalEditDepartment">Edit</a>')
                            ->make(true);
     }

     public function documentLoglist()
     {   
        return view('documents.list-document-log.blade');        
     }


     public function show_repository()
     {
        
            $DocumentRepoService =  new DocumentRepoService;    
            $allSubCategories= $DocumentRepoService->getCategories();   
            $data = array();
            $data['DocumentRepository'] = $allSubCategories;  
        
            if(\Session::has('success')){
                // echo "<pre>"; print_r(\session()->all());
            }
           

             //echo  \Session::get('parent_folders');

            // echo  \Session::get('current_folder_id');
           

            if(!empty($data['DocumentRepository']))
            {
                if(\Session::has('current_folder_id')){                
                   $last_folder_id =  \Session::get('current_folder_id'); //if user create subfolder and select them
                }else{
                   $last_folder_id =  @$data['DocumentRepository'][0]->id;
                }                
 
                $myfolderdata = $DocumentRepoService->getFolderImages($last_folder_id);

                $data['folder_DocumentRepository'] =   $myfolderdata['folderdata'];

                $data['folder_images'] =   $myfolderdata['folderImages'];           
            }    

            if(\Session::has('parent_folders'))
            {
                $parent_folder = \Session::get('parent_folders');
                $data['parent_folders']  = explode('/',$parent_folder);   
            }

            return view('documents.list-repository',$data);

            //return view('documents.list',$data);


     }


    function folder_document($folder_id,$type=null)
     {
        if($folder_id)
        {
           $DocumentRepoService =  new DocumentRepoService;  

           $myfolderdata = $DocumentRepoService->getFolderImages($folder_id); 

           $data['folder_data'] =   $myfolderdata['folderdata'];
           $data['folder_images'] =   $myfolderdata['folderImages'];  
           echo json_encode($data); die;
        }
     }


     private function  getAllParentDirectory($id)
     {

           $DocumentRepoService =  new DocumentRepoService; 

           try {

                $allCategories = $DocumentRepoService->selectParent($id);            
            } catch (Exception $e) {            
                //no parent category found
            }

            $folderData= '';

            foreach($allCategories as $parent1)
            {              
               $folderData = $parent1['name']."/".$folderData;

                if($parent1->ParentCategory)
                {
                   foreach($parent1->ParentCategory as $parent2)
                    {
                       $folderData = $parent2['name']."/".$folderData;

                        if($parent2->ParentCategory)
                        {  
                           foreach($parent2->ParentCategory as $parent3)
                            {
                                 $folderData = $parent3['name']."/".$folderData;

                                if($parent3->ParentCategory)
                                    {
                                           foreach($parent2->ParentCategory as $parent3)
                                            {

                                            }
                                    }

                            }
                        }

                    }
                }

                
            }
           
       return  $folderData; 
     }


    public function addFolder($id=null)
    {
        if($id)
        {          
             $data['folderdata']= DocumentRepository::where('document_repositories.id',$id)->first();
             
             $data['permissions']= DB::table('document_permissions')
            ->where('document_permissions.folder_id',$id)         
            ->select('role_id','is_read','is_write')          
            ->get();
            
             return view('documents.editFolder', $data);

        }else{
            return view('documents.addFolder');
        }        
    }

     public function saveEditFolder(DocumentRepositoryRequest $request)
    {                   

        $documents          = array();
        $documents['name']    = trim(strip_tags($request['name']));  
        $description        = trim(strip_tags($request['description']));
        $version        = $request['version'];
        $notes        = trim(strip_tags($request['note']));

        if(is_array($request['role']))
        {
            $group_id = implode(',',$request['role']);
        }else{
            $group_id = $request['role'];
        }

        $documents['description']    = $description;
        $documents['pesmission_id']    = $request['premissions'];
        $documents['doc_version']    = $version;
        $documents['notes']    = $notes;
        $documents['group_id']    = $group_id;      
        $documents['user_id'] = \Auth::user()->id;
        $documents['status'] = $request['status']; 
        $documents['updated_at'] = date('y-m-d h:i:s');       

        if($request->folder_id)
        {   
                $folderData = $this->getAllParentDirectory($request->folder_id); 

                //echo $folderData;

                if($request->folder_id)
                {  
                    $path = public_path().'/document_repository/'.$folderData.'/'. trim($request['name']);
                }else{
                    $path = public_path().'/document_repository/'. trim($request['name']);
                }

              // echo print_r($request['role']); die;

               $update = DB::table('document_repositories')
               ->where('id', $request->folder_id)
               ->update($documents); 

               if($update) {

                   $delete = DB::table('document_permissions')
                   ->where('folder_id',$request->folder_id)
                   ->delete(); 

                     if($request['role']) {

                        $permission = $request->permission;  

                        foreach($request['role'] as $key=>$val){ 

                            $is_read =0;  $is_write =0;

                            if(@$permission[$val][0]==1){
                                $is_read=1;
                            }

                            if(@$permission[$val][0]==2){
                                $is_write=1;
                            }

                            if(@$permission[$val][1]==2){
                               $is_write=1;
                            }

                             $permissiondata = array(
                                'role_id'=>$val,
                                'is_read'=>$is_read,
                                'is_write'=>$is_write,
                                'folder_id'=> $request->folder_id
                                );   
                             
                             DB::table('document_permissions')->insert($permissiondata);                             
                         }
                    }

                     //File::makeDirectory($path, 0777, true, true);
                \Session::flash('success', 'well done! Documents '.$request['name'].' has been successfully added!');

               }

                /* manage the to show all sub directory */ 
                   if($folderData){
                        \Session::set('parent_folders',$folderData.trim($request['name'])); 
                    }
                   \Session::set('current_folder_id',$request->folder_id);

               /* manage the to show all sub directory */ 


         }           

       return redirect('/show_repository')->withInput(Input::flash());

    }

    
    public function store(DocumentRepositoryRequest $request)
    {     
       
        $folderData = $this->getAllParentDirectory($request['folder_id']); 
        $documents          = new DocumentRepository();
        $documents->name    = trim(strip_tags($request['name']));  
        $description        = trim(strip_tags($request['description']));
        $version        = preg_replace('/\s+/','-',$request['version']);
        $notes        = trim(strip_tags($request['note']));

        if(is_array($request['role']))
        {
            $group_id = implode(',',$request['role']);
        }else{
            $group_id = $request['role'];
        }

        $documents->description    = $description;
        $documents->pesmission_id    = $request['premissions'];
        $documents->doc_version    = $version;
        $documents->notes    = $notes;
        $documents->group_id    = $group_id;      
        $documents->user_id = \Auth::user()->id;
        $documents->status = $request['status'];        

        if($request['folder_id'])
        {             
            $documents->parent_id = $request['folder_id'];
            $documents->lavel = ($request['folder_lavel']+1); 
            $path = public_path().'/document_repository/'.$folderData.'/'. trim($request['name']);
        }else{
            $path = public_path().'/document_repository/'. trim($request['name']);
        }
        
        if($documents->save())
        {   
               $path1 = app_path().'/document_repository/'. trim($request['name']);

               $folder_id = $documents->id;

               if($request['role'])
               {
                    $permission = $request->permission;                       
                    foreach($request['role'] as $key=>$val){      

                         $permissiondata = array(
                            'role_id'=>$val,
                            'is_read'=>(@$permission[$val][0])?1:0,
                            'is_write'=>(@$permission[$val][1])?1:0,
                            'folder_id'=>$folder_id
                            );  

                         DB::table('document_permissions')->insert($permissiondata);                             
                     }
               }

            File::makeDirectory($path, 0777, true, true);

            \Session::flash('success', 'well done! Documents '.$request['name'].' has been successfully added!');
        }  

        /* manage the to show all sub directory */ 
           if($folderData){
                \Session::set('parent_folders',$folderData.trim($request['name'])); 
            }
           \Session::set('current_folder_id',$folder_id);

       /* manage the to show all sub directory */ 


       return redirect('/show_repository')->withInput(Input::flash());

    }

    public function addSubFolder($folder_id,$folder_lavel=null)
    {
        if($folder_lavel)
        {
            $data['folder_lavel'] = $folder_lavel;
        }else{
            $data['folder_lavel'] = 0;
        }

        $documents          = new DocumentRepository();
        $data['document']  = $documents->select('id','name')->where('id',$folder_id)->first();
        $data['folder_id'] = $folder_id;       
        return view('documents.addSubFolder',$data);

    }

    public function addDocumentfile($folder_id,$folder_lavel=null)
    {
        if($folder_lavel)
        {
            $data['folder_lavel'] = $folder_lavel;
        }else{
            $data['folder_lavel'] = 0;
        }

        $documents          = new DocumentRepository();
        $data['document']  = $documents->select('id','name')->where('id',$folder_id)->first();
        $data['folder_id'] = $folder_id;       
        return view('documents.addDocumentFile',$data);
    }


    public function saveDocumentfile(DocumentRepositoryRequest $request)
    {    

        $folderData = $this->getAllParentDirectory($request['folder_id']);         

        if($request['folder_id'])
        { 
            $folder_path = 'document_repository/'.$folderData;
        }else{
            $folder_path = 'document_repository/'.$folderData;
        }

        $fileName_original          = $request->file('upload_doc')->getClientOriginalName();

        $extension = $request->file('upload_doc')->getClientOriginalExtension();
        
        $fileName = time().'.'.$extension;  

        $fileFullPath      = $folder_path.''.$fileName;

        $request->file('upload_doc')->move($folder_path,$fileName); 

        $DocumentImage          = new DocumentImage();

        $DocumentImage->name    = trim(strip_tags($fileName_original));  
        $description        = trim(strip_tags($request['description']));
        $notes        = trim(strip_tags($request['note']));


        if(is_array($request['role']))
        {
            $group_id = implode(',',$request['role']);
        }else{
            $group_id = $request['role'];
        }



        $DocumentImage->description    = $description;   
        $DocumentImage->img_url    = $fileFullPath;
        $DocumentImage->notes    = $notes;        
        $DocumentImage->folder_id = $request['folder_id'];
        $DocumentImage->group_id    = $group_id;
        $DocumentImage->user_id = \Auth::user()->id;

        // echo "<pre>"; print_r($_REQUEST);  echo "<pre>"; print_r($DocumentImage); die;
        
        if($DocumentImage->save())
        {  
             $insertedId = $DocumentImage->id;

             $logdata = array(
                'document_id'=> $insertedId,
                'document_type'=>'documents',
                 'document_path'=>$folder_path,
                 'operation'=>'create',          
                 'user_id'=>\Auth::user()->id
              );

             $this->manageDocumentLog($logdata);
             //$this->manageDocumentPermission($permissiondata);

            \Session::flash('success', 'well done! Documents '.$request['name'].' has been successfully added!');


           if($folderData){
                \Session::set('parent_folders',$folderData.trim($request['name'])); 
            }
           \Session::set('current_folder_id',$request['folder_id']);
           
        }  

        //return redirect()->back()->withInput(Input::flash());   

         return redirect('/show_repository')->withInput(Input::flash());

    }


    public function edit($id,DocumentRepository $documents)
    {
      
        $dept    = documents::where('id',$id)->first();
        return [$dept];
    }

    public function update(DepartmentRequest $request)
    {

        $dept             = Department::where('id',$request['deptID'])->first();
        $dept->name       = $request['name'];
        $dept->updated_by = \Auth::user()->id;
        $dept->save();
        \Session::flash('success', 'well done! Role '.$request['name'].' has been successfully added!');
        return redirect()->back();
    }



    public function manageDocumentLog($data)
    {
         if($data)
         {
            $last_id = DB::table('document_logs')-> insertGetId($data);
            return $last_id;
         }  
    }

    public function documentDelete($id)
    {
        if($id)
        {
             $data = DocumentImage::where('id',$id)->first();          
            
             $img_url = app_path().''.$data->img_url;  //unlink($img_url); 


             $logdata = array(
                 'document_id'=> $id,
                 'document_type'=>'documents',                
                 'operation'=>'delete',          
                 'user_id'=>\Auth::user()->id
              );
             $this->manageDocumentLog($logdata);
         

           if(DocumentImage::where('id',$id)->delete())
           {          
             return 1;

           }else{
            return 0;
           }
           
        }
    }

    function downloadsDoc($id)
    {
       if($id)
        {
            $data = DocumentImage::where('id',$id)->first();
            $myFile = public_path($data->img_url);

            $logdata = array(
                'document_id'=> $id,
                'document_type'=>'documents',
                'operation'=>'download',          
                'user_id'=>\Auth::user()->id
              );

             $this->manageDocumentLog($logdata);

           
            
            if($data->name!='')
            {
                $ext = explode('.',$data->name);
                $ext = end($ext);              
            }                

            if($ext=='jpeg' || $ext=='jpg'|| $ext=='png' || $ext=='gif')
            {
                 return response()->download($myFile); 
            }else{
                 
                 if($ext=='pdf') {
                     $headers = ['Content-Type: application/pdf'];
                     $newName = 'downloadfile-'.time().'.pdf';                 
                 }

                 if($ext=='xls' || $ext=='xlsx') {
                     $headers = ['Content-Type: application/vnd.ms-excel'];
                     $newName = 'downloadfile-'.time().'.xls';                 
                 }

                 if($ext=='txt') {
                     $headers = ['Content-Type: application/vnd.oasis.opendocument.text'];
                     $newName = 'downloadfile-'.time().'.txt';                 
                 }

                 if($ext=='doc' || $ext=='docx') {
                     $headers = ['Content-Type: application/msword'];
                     $newName = 'download-pdf-'.time().'.doc';                 
                 }
								 
								                
              
                 return response()->download($myFile, $newName, $headers);
            }          

      
            
         }
    }

}

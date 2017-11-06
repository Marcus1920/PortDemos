<?php

namespace App\Services;
use App\DocumentRepository;
use App\DocumentImage;
use DB;

class DocumentRepoService
{

     public function getCategories(){

        $colname = \Auth::user()->role;

        /* $categories = DocumentRepository::where('parent_id',0)->whereIn('group_id',array($colname))->orderBy('id', 'DESC')->get(); 
          /*$categories1 = DB::table('document_repositories')->where('parent_id',0)
         ->whereRaw('FIND_IN_SET(?,group_id)', [$colname])
         ->get();*/

          $categories = DocumentRepository::select('*')->where('parent_id',0)->whereRaw('FIND_IN_SET(?,group_id)', [$colname])        
           ->orderBy('id','DESC')->get();

          $categories = $this->addRelation($categories); 
             

          return $categories;

        }

        protected function selectChild($id)
        {
        	$colname = \Auth::user()->role;
            $categories = DocumentRepository::where('parent_id',$id)->whereRaw('FIND_IN_SET(?,group_id)', [$colname])        
           ->get(); 

            $categories = $this->addRelation($categories);

            return $categories;

        }       


        protected function addRelation($categories){

              $categories->map(function ($item, $key) {
                
                $sub = $this->selectChild($item->id); 
                
                return $item = array_add($item,'subCategory',$sub);

            });

            return $categories;
        }



        protected function addRelation1($categories){

            $categories->map(function ($item, $key) {
                
                $sub = $this->selectParent($item->parent_id); 
                
                return $item = array_add($item,'ParentCategory',$sub);

            });

            return $categories;
        }


        public function selectParent($id)
        {
            $categories = DocumentRepository::where('id',$id)->get(); 

            $categories=$this->addRelation1($categories);

            return $categories;

        }

        public function getFolderImages($folder_id)
        {
        	   $colname = \Auth::user()->role;

	        	$folderdata = DB::table('users')
	           ->join('document_repositories', 'document_repositories.user_id', '=', 'users.id') 
	           ->leftjoin('document_permissions','document_permissions.folder_id', '=', 'document_repositories.id')  
	           ->select('document_repositories.id','document_repositories.name','document_repositories.user_id','document_repositories.description','document_repositories.created_at','document_repositories.lavel','document_repositories.description','users.name as username','document_permissions.is_read','document_permissions.is_write')	           
	            ->whereRaw('FIND_IN_SET(?,group_id)', [$colname])	         
	            ->where('document_repositories.status',1)
	            ->where('document_repositories.id',$folder_id)
	            ->where(function ($query) use ($folder_id,$colname) {
				      return $query				      		  
                              ->where('document_permissions.folder_id',$folder_id)
                              ->where('document_permissions.role_id', $colname);                            
				  })	
	            ->orderBy('id', 'DESC')->first();            

	           $data['folderdata'] = $folderdata;
               $DocumentImage = new DocumentImage();       

               $folderImages =  $DocumentImage->where('folder_id',$folder_id)->whereRaw('FIND_IN_SET(?,group_id)', [$colname])->select("*")->get();

                $data['folderImages'] = $folderImages;

               return $data;
               // ->orWhereRaw('document_permissions1.folder_id='.$folder_id.' and document_permissions.role_id='.$colname.'')	

        }


        


}
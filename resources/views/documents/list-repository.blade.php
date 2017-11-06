@extends('master')

@section('content')
<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->
<style type="text/css">  
  .folder-img{  width: 100%; height:115px;  padding: 5px; }
  .details{margin-left: 10px;}
  .left-section{border-right: 1px solid rgba(255,255,255,0.15);;min-height:400px;}
  .delete{color:#CC0000;margin-right:20px;cursor:pointer;}
  .rename{ position: absolute;top:15px; float:right;right: 5px;}

  .list-documents{margin-left: 10px; }
  .list-images{border:1px solid rgba(221, 221, 221, 0.35); padding: 2px;
    margin-right: 5px;}
</style>

<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="#">Administration</a></li>
    <li><a href="{{ url('show_repository') }}">Folder</a></li>
    <li class="active">Documents Listing</li>
</ol>

<h4 class="page-title"> DOCUMENTS REPOSITORY LISTING   </h4>



<!-- Alternative -->
<div class="block-area" id="alternative-buttons"> 
   <!--  <a class="btn btn-sm" id="addFolder" data-toggle="modal"  data-target=".modalAddDocument">
     Add Folders 
    </a> -->
     <a class="btn btn-sm" id="addFolder" href="{{ url('/addfolder') }}">
     Add Folders 
    </a>
</div>

<!-- Responsive Table style="overflow-x: auto;max-height: 400px;"  -->
<div class="block-area" id="responsiveTable">
    @if(Session::has('success'))
      <div class="alert alert-success alert-icon">
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('success') }}
          <i class="icon">&#61845;</i>
      </div>
    @endif

    <div class="table-responsive overflow " style="border-top:1px solid rgba(255,255,255,0.15);">

      <div class="col-md-3 left-section">
          <ul class="nav" >        
            @foreach(@$DocumentRepository as $repo)       
                <li id="btn_add_album_rightbar" class="parent">
                  <?php if(@$repo->id == @$folder_DocumentRepository->id)
                      $class1 = 'active';
                    else
                      $class1 = '';

                    $folder_class="fa-folder";                    


                    
                    if(@$parent_folders[0]){                  
                       if($repo->name==$parent_folders[0])
                        {
                           $folder_class="fa-folder-open";
                           $class1 = 'active';
                        }else{
                            $folder_class="fa-folder";
                            $class1 = '';    
                        }
                    }

                   

                   ?>

                   <a  class="list-group-item <?php  echo $class1; ?> " href="javascript:void(0);" onclick="show_details('{!! $repo->id !!}','{!! $repo->lavel !!}')" class="add-album">  <i class="fa <?php echo $folder_class;?>" aria-hidden="true"> </i>  {!! $repo->name !!} 
                   </a>                          
                </li>                  

                @if($repo->subCategory) 
                <?php              
                  
                    if(@$parent_folders[1]!='' && $repo->name==$parent_folders[0])
                    {
                      $subCategory_class='show';
                    }else{
                      $subCategory_class= "hide";
                    }            
                  ?>

                 <ul class="<?php  echo $subCategory_class;?>">

                   @foreach ($repo->subCategory as $child)
                   <?php 
                   
                     $child_class="fa-folder";
                     $class2 = '';

                    if(@$parent_folders[1]){  
                     if($child->name==$parent_folders[1])
                      {
                         $child_class="fa-folder-open";
                         $class2 = 'active';
                      }else{
                            $child_class="fa-folder";
                             $class2 = '';    
                        }
                    }
                    ?>

                        <li id="btn_add_album_rightbar" class="parent">
                               <a  class="list-group-item <?php echo $class2;?>" href="javascript:void(0);" onclick="show_details('{!! $child->id !!}','{!! $child->lavel !!}')" class="add-album"> <i class="fa <?php echo $child_class;?>" aria-hidden="true"> </i>  {!! $child->name !!}
                             </a>
                        </li>
                    @if($child->subCategory) 

                   <?php   
                    if(@$parent_folders[2]!='' && $child->name==$parent_folders[1])
                    {
                      $subCategory2_class='show';
                    }else{
                      $subCategory2_class= "hide";
                    }  
                    ?>

                       <ul class="<?php  echo $subCategory2_class;?>">
                        @foreach ($child->subCategory as $child1)

                          <?php
                            $child1_class="fa-folder";
                            $class3 = '';

                            if(@$parent_folders[2]){  
                              if($child1->name==$parent_folders[2])
                              {
                                 $child1_class="fa-folder-open";
                                  $class3 = 'active';
                              }else{
                                $child1_class="fa-folder";
                                $class3 = '';    
                            }
                           }
                          ?>

                          <li id="btn_add_album_rightbar" class="parent">
                                 <a  class="list-group-item <?php echo $class3;?>" href="javascript:void(0);" onclick="show_details('{!! $child1->id !!}','{!! $child1->lavel !!}')" class="add-album"> <i class="fa fa-folder" aria-hidden="true"></i> {!! $child1->name !!}
                               </a>
                          </li>
                          @if($child1->subCategory)
                             <?php
                                if(@$parent_folders[3]!='' && $child1->name==$parent_folders[2])
                                {
                                  $subCategory3_class='show';
                                }else{
                                  $subCategory3_class= "hide";
                                }                   
                              ?>

                             <ul class="<?php echo $subCategory3_class;?>">
                              @foreach ($child1->subCategory as $child2)
                                 <?php 
                                   $class4 = '';
                                   $child2_class="fa-folder";

                                  if(@$parent_folders[3]){
                                      if(@$child2->name==$parent_folders[3])
                                      {
                                          $child2_class="fa-folder-open";
                                          $class4 = 'active';
                                      }else{
                                          $child2_class="fa-folder";
                                         $class4 = '';    
                                      }
                                  }                                      
                                ?>

                                <li id="btn_add_album_rightbar" class="parent <?php echo $class4;?>">
                                       <a  class="list-group-item" href="javascript:void(0);" onclick="show_details('{!! $child2->id !!}','{!! $child2->lavel !!}')" class="add-album"> 
                                         <i class="fa <?php echo $child1_class;?>" aria-hidden="true"></i>  {!! $child2->name !!}
                                     </a>
                                </li>

                             @if($child2->subCategory)

                              <?php
                                if(@$parent_folders[4]!='')
                                {
                                  $subCategory4_class='show';
                                }else{
                                  $subCategory4_class= "hide";
                                }                   
                              ?>

                                 <ul class="<?php  echo $subCategory4_class;?>">
                                  @foreach ($child2->subCategory as $child3)
                                    <?php 
                                     $child3_class="fa-folder";
                                     $class5 = '';
                                     if(@$parent_folders[4]){ 
                                        if(@$child3->name==$parent_folders[4])
                                        {
                                            $child3_class="fa-folder-open";
                                            $class5 = 'active';
                                        }else{
                                            $child3_class="fa-folder";
                                           $class5 = '';    
                                        }
                                     }
                                    ?>

                                    <li id="btn_add_album_rightbar" class="parent">
                                           <a  class="list-group-item  <?php  echo $class5;?>" href="javascript:void(0);" onclick="show_details('{!! $child3->id !!}','{!! $child3->lavel !!}')" class="add-album"> <i class="fa <?php  echo $child3_class;?>" aria-hidden="true"> </i> {!! $child3->name !!}
                                         </a>
                                    </li>
                                  @endforeach
                                </ul>
                              @endif

                              @endforeach
                            </ul>
                          @endif

                        @endforeach
                      </ul>
                    @endif

                  @endforeach
                </ul>
                @endif
          @endforeach

         </ul>
      </div>

      <div class="col-md-9">         
          @if(@$folder_DocumentRepository->username) 
              <div class="block-area " id="alternative-buttons" style="background: rgba(255, 255, 255, 0.15);color:white;" >     
                <div class="col-md-6 active "> 
                    <h4 id="DocumentRepositoryTitile">
                         {!! ucfirst(@$folder_DocumentRepository->name) !!}
                    </h4>  
                </div>
                 <?php                 
                   if($folder_DocumentRepository->is_write==1) 
                     $class1 = 'show';
                   else
                     $class1 = 'hide'; // hide                 
                   ?>
                    <div class="col-md-4 {!! $class1 !!} " id="addFolderPermissionButton" > 
                        <a class="btn btn-sm pull-left" id="addSubFolder" href="{!! url('/addSubFolder')!!}/{!! @$folder_DocumentRepository->id !!}/{!! @$folder_DocumentRepository->lavel !!}">
                         Add sub Folder  
                        </a>  
                        <a class="btn btn-sm pull-right" id="addDocumentfile"  style="margin-left:10px;" href="{!! url('/addDocumentfile')!!}/{!! @$folder_DocumentRepository->id !!}/{!! @$folder_DocumentRepository->lavel !!}">
                         Upload Files
                        </a>                       
                   </div>    

                   @if($folder_DocumentRepository->user_id==\Auth::user()->id)
                     <div class="col-md-2"> 
                         <a class="btn btn-sm pull-center" id="editfolder"  style="margin-left:10px;" href="{!! url('/addfolder')!!}/{!! @$folder_DocumentRepository->id !!}">
                         Edit Folder  
                        </a>
                     </div>
                   @endif                 
           

            </div>
            @endif                    
       

         <br/>

       
         <div clas="col-md-12" id="show_folder_data" alt="{!! @$folder_DocumentRepository->id !!}">  
               @if(@$folder_DocumentRepository->username)     
                 <div class="details"> 
                    <p id="rep_name">  User Name : {!! @$folder_DocumentRepository->username !!} </p>
                    <p id="rep_descp">  Description : {!! @$folder_DocumentRepository->description !!} </p>
                 </div>
               @endif 
             
             @if(@$folder_DocumentRepository->is_read==1) 

               @if(!$folder_images->isEmpty())
                  <div id="img_url_data" class="list-documents">
                    @foreach($folder_images as $files)
                     <div class="col-md-3 list-images" id="images_{!! @$files->id !!}" > 

                         <?php 
                          if($files->name!='')
                          {
                              $ext = explode('.',$files->name);
                              $ext = end($ext);              
                          }          

                          if($ext=='jpeg' || $ext=='jpg'|| $ext=='png' || $ext=='gif')
                          {
                               $src = url()."/".htmlentities($files->img_url);                              
                          }else{                               
                               if($ext=='pdf' || $ext=='PDF') {                                   
                                  $src = url('img')."/pdf.png";         
                               }
                               if($ext=='xls' || $ext=='XLS' || $ext=='xlsx' ||$ext=='XLXS') {
                                  $src =url('img')."/xls.png";             
                               }
                               if($ext=='txt') {
                                $src =  url('img')."/pdf.jpg";          
                               }
                               if($ext=='doc' || $ext=='DOC' || $ext=='DOCX' ||$ext=='docx') {                                  
                                  $src = url('img')."/doc.png";              
                               }                 
                          }
                         ?>
                           <img src="{!! $src !!}" class="folder-img" alt="{!! @$files->notes !!}" /> 


                       <p> {!! @$files->name !!}   
                        <i class='fa fa-times pull-right delete' aria-hidden='true' data="{!! @$files->id !!}"></i> 

                        <a href="{!! url('downloadsDoc')!!}/{!! @$files->id !!}"> <i class='fa fa-download' aria-hidden='true'></i> </a>
                        </p> 
                    </div>
                    @endforeach
                </div>
                
                  @else
                   <div id="img_url_data" class="list-documents">   </div>
                @endif 

              </p>

                @endif    

              <input type="hidden" id="current_folder_id"  value="{!! @$folder_DocumentRepository->id !!}"> 
              <input type="hidden" id="current_folder_lavel"  value="{!! @$folder_DocumentRepository->lavel !!}">
            
         </div> 


    </div>
</div>

@include('documents.edit')
@include('documents.add')
@endsection

@section('footer')

 <script>
 $(document).ready(function(){
    //$('.nav').niceScroll();

    $(".parent").click(function(){
       
         if($(this).next('ul').hasClass('hide'))
         {
            $(this).children().children().removeClass('fa fa-folder').addClass('fa fa-folder-open');            
            $(this).next('ul').removeClass('hide');
         }else{
            $(this).next('ul').addClass('hide');
            $(this).children().children().removeClass('fa fa-folder-open').addClass('fa fa-folder');
         }
       
    });


 });

    function show_details(id,lavel1){ 
console.log('show_details(id,lavel1) id - ',id,', lavel1 - ',lavel1);
      if(id)
      { 
         var new_url = "{!! url('/addSubFolder/"+id + "/"+lavel1+"')!!}";
         var new_url2 = "{!! url('/addDocumentfile/"+id + "/"+lavel1+"')!!}";   

         var new_url3 = "{!! url('/addfolder/"+id +"') !!}";   

         $("#addSubFolder").attr('href',new_url);         
         $("#addDocumentfile").attr('href',new_url2);
         $("#editfolder").attr('href',new_url3);

          $('.list-group-item').removeClass('active');
          $(this).addClass('active');       

          $("#current_folder_id").val(id);
          $("#current_folder_lavel").val(lavel1);

          $.ajax({
            type    :"GET",
            dataType:"json",
            url     :"{!! url('/folder-documents/"+id + "/ajax')!!}",     
            success :function(data) {
              console.log(data); 
              //var response = JSON.paser(data);

              if(data)
              {  
               
                if(data.folder_data)
                {
                    if(data.folder_data.is_read==1){
                       $("#img_url_data").show();
                    }else{
                       $("#img_url_data").hide();
                    }

                    if(data.folder_data.is_write==1){
                      
                      $("#addFolderPermissionButton").removeClass('hide'); //.addclass('show');
                      $("#addFolderPermissionButton").show();
                    }else{
                       $("#addFolderPermissionButton").removeClass('show'); //.addclass('hide');
                       $("#addFolderPermissionButton").hide();
                    }    


                   if(data.folder_data.lavel>=4)
                    {
                      $("#addSubFolder").hide();
                    }else{
                      $("#addSubFolder").show();
                    }

                     $("#DocumentRepositoryTitile").html(data.folder_data.name);
                     $("#rep_name").text('User Name : '+data.folder_data.username);
                     $("#rep_descp").text('Description : '+data.folder_data.description);
                }else{

                }



                if(data.folder_images!='')
                { 
                    var images= '';
                    $(data.folder_images).each(function(index,value){                              
                       var im_url = htmlEntities(value.img_url);
                       var src = check_extention(im_url);
                     
                      images+=" <div class='col-md-3 list-images' id='images_"+value.id+"'>";
                      images+='<img src="'+src+'" class="folder-img" alt="'+value.notes+'"/><p>';
                      images+="<span>"+value.name+"</span>  <i class='fa fa-times pull-right delete' aria-hidden='true' data="+value.id+"></i> <a href='{!! url('/downloadsDoc/"+value.id + "')!!}'> <i class='fa fa-download' aria-hidden='true'></i></a>  </p> </div>";
                    });
               
                    $("#img_url_data").html(images);
                    $("#img_url_data").show();

                }else{                    
                  $("#img_url_data").text('').hide();
                }
                    deleteUploadDoc();
               
              }else{
                $("#show_folder_data").html('Data not found ');
              }
            }
          });
        }  
   }


  $("#addFolder1").click(function(){  
     $('#UpdateDocumentForm')[0].reset();
  });


  $("#addSubFolder1").click(function(){
     addSubFolder();
  });

function check_extention(image_url)
{
     var extention = image_url.split('.').pop();

    if(extention=='jpeg' || extention=='jpg'|| extention=='png' || extention=='gif')
      {
           var src = image_url;                   
      }else{                               
           if(extention=='pdf'|| extention=='PDF') {                                   
              var src =  "{!! url('img')!!}/pdf.png";         
           }
           if(extention=='xls' || extention=='xlsx' || extention=='XLS' ||extention=='XLXS') 
           {
              var src ="{!! url('img')!!}/xls.png";             
           }
           if(extention=='txt') {
            var src =  "{!! url('img')!!}/pdf.jpg";          
           }
           if(extention=='doc' || extention=='DOC' || extention=='docx' || extention=='DOCX') {                                  
              var src = "{!! url('img')!!}/doc.png";              
           }                 
      } 

      return src;
}


function htmlEntities(str) {
     return String(str).replace(/&amp;/g, '&').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function deleteUploadDoc()
{
   $(".fa-times").click(function(){  
     if(!confirm('do you want to delete?')){
      return false;
     }  

      var doc_id = $(this).attr('data');
      if(doc_id)
      {
         $.ajax({
          type    :"GET",       
          url     :"{!! url('/documentDelete/"+ doc_id + "')!!}",
          success :function(data) {            
              if(data)
              {
                $("#images_"+doc_id+"").hide();
              }
          
            }
         });
      }
    });
}

deleteUploadDoc();


 function addSubFolder()
  {
     var folder_id = $("#current_folder_id").val();
     var folder_lavel = $("#current_folder_lavel").val();
     folder_lavel= (folder_lavel)?folder_lavel:0;

      $("#folder_id").val(folder_id);
      $("#folder_lavel").val(folder_lavel);
      $('#modalAddDocument').modal('show');
  }


  function addDocumnets()
  { 
      var folder_id = $("#current_folder_id").val();
      var folder_lavel = $("#current_folder_lavel").val();
      folder_lavel= (folder_lavel)?folder_lavel:0;

      $("#folder_id1").val(folder_id);
      $("#folder_lavel1").val(folder_lavel);
      $('#modalAddDocument1').modal('show');
  }


 function launchUpdateDepartmentModal(id)
  {
      $(".modal-body #docID").val(id);
       $.ajax({
        type    :"GET",
        dataType:"json",
        url     :"{!! url('/documents/"+ id + "')!!}",
        success :function(data) {

            if(data[0] !== null)
            {
               $("#modalEditdocuments #name").val(data[0].name);
               $("#modalEditdocuments #description").val(data[0].description);
            }
            else {

               $("#modalEditdocuments #name").val('');
               $("#modalEditdocuments #description").val('');
            }

        }
    });

  }


  @if (count($errors) > 0)
      @if(Input::get ('docID'))
        $('#modalEditdocuments').modal('show');
      @else
        $('#modalAddDocument').modal('show');
      @endif      
  @endif


</script>
@endsection

<?php 
 Session::forget('parent_folders');
 Session::forget('current_folder_id');   
?>

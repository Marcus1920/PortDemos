@extends('master')

@section('content')
<style type="text/css">  
  .folder-img{  width: 100px;  height: 80px;    padding: 2px; }
  .details{margin-left: 10px;}
  .left-section{border-right: 1px solid rgba(255,255,255,0.15);;min-height:400px;}
  .delete{color:#CC0000;margin-right:20px;cursor:pointer;}
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

                @if($repo->group_id == \Auth::user()->role)  
                    <li id="btn_add_album_rightbar" class="parent">
                      <?php if($repo->id == $folder_DocumentRepository->id)
                         $class1 = 'active';
                        else
                        $class1 = '';
                       ?>
                       <a  class="list-group-item <?php  echo $class1; ?> " href="javascript:void(0);" onclick="show_details('{!! $repo->id !!}','{!! $repo->lavel !!}')" class="add-album">  <i class="fa fa-folder" aria-hidden="true"> </i>  {!! $repo->name !!} 
                       </a>              
                    </li>
                @endif 

                @if($repo->subCategory)                             
                 <ul class="hide">
                   @foreach ($repo->subCategory as $child)

                        <li id="btn_add_album_rightbar" class="parent">
                               <a  class="list-group-item" href="javascript:void(0);" onclick="show_details('{!! $child->id !!}','{!! $child->lavel !!}')" class="add-album"> <i class="fa fa-folder" aria-hidden="true"> </i>  {!! $child->name !!}
                             </a>
                        </li>
                    @if($child->subCategory)                             
                       <ul class="hide">
                        @foreach ($child->subCategory as $child1)
                          <li id="btn_add_album_rightbar" class="parent">
                                 <a  class="list-group-item" href="javascript:void(0);" onclick="show_details('{!! $child1->id !!}','{!! $child1->lavel !!}')" class="add-album"> <i class="fa fa-folder" aria-hidden="true"></i> {!! $child1->name !!}
                               </a>
                          </li>
                          @if($child1->subCategory)                             
                             <ul class="hide">
                              @foreach ($child1->subCategory as $child2)
                                <li id="btn_add_album_rightbar" class="parent">
                                       <a  class="list-group-item" href="javascript:void(0);" onclick="show_details('{!! $child2->id !!}','{!! $child2->lavel !!}')" class="add-album"> <i class="fa fa-folder" aria-hidden="true"></i>  {!! $child2->name !!}
                                     </a>
                                </li>

                                @if($child2->subCategory)                             
                                 <ul class="hide">
                                  @foreach ($child2->subCategory as $child3)
                                    <li id="btn_add_album_rightbar" class="parent">
                                           <a  class="list-group-item" href="javascript:void(0);" onclick="show_details('{!! $child3->id !!}','{!! $child3->lavel !!}')" class="add-album"> <i class="fa fa-folder" aria-hidden="true"> </i> {!! $child3->name !!}
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
                <div class="col-md-8 active "> 
                    <h4 id="DocumentRepositoryTitile">
                         {!! ucfirst(@$folder_DocumentRepository->name) !!}
                    </h4>  
                </div>

                 <div class="col-md-4"> 
                      <a class="btn btn-sm pull-left" id="addSubFolder" href="{!! url('/addSubFolder')!!}/{!! @$folder_DocumentRepository->id !!}/{!! @$folder_DocumentRepository->lavel !!}">
                       Add sub Folder  
                      </a>                
                      <a class="btn btn-sm pull-right" id="addDocumentfile"  style="margin-left:10px;" href="{!! url('/addDocumentfile')!!}/{!! @$folder_DocumentRepository->id !!}/{!! @$folder_DocumentRepository->lavel !!}">
                       Add Documents  
                      </a>
                </div>
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
             
               @if(!$folder_images->isEmpty())
                  <div id="img_url_data" >
                    @foreach($folder_images as $files)
                     <div class="col-md-2" id="images_{!! @$files->id !!}"> 

                         <?php 
                          if($files->name!='')
                          {
                              $ext = explode('.',$files->name);
                              $ext = end($ext);              
                          }          

                          if($ext=='jpeg' || $ext=='jpg'|| $ext=='png' || $ext=='gif')
                          {
                               $src = url()."/".$files->img_url;                              
                          }else{                               
                               if($ext=='pdf') {                                   
                                  $src = url('img')."/pdf.png";         
                               }
                               if($ext=='xls') {
                                  $src =url('img')."/xls.png";             
                               }
                               if($ext=='txt') {
                                $src =  url('img')."/pdf.jpg";          
                               }
                               if($ext=='doc') {                                  
                                  $src = url('img')."/doc.png";              
                               }                 
                          }
                         ?>
                           <img src="{!! $src !!}" class="folder-img" alt="{!! @$files->notes !!}"/> 


                       <p> {!! @$files->name !!}   
                        <i class='fa fa-times pull-right delete' aria-hidden='true' data="{!! @$files->id !!}"></i> 

                        <a href="{!! url('downloadsDoc')!!}/{!! @$files->id !!}"> <i class='fa fa-download' aria-hidden='true'></i> </a>
                        </p> 
                    </div>
                    @endforeach
                </div>
                
                  @else
                   <div id="img_url_data">   </div>
                @endif 

              </p>

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

      if(id)
      { 
         var new_url = "{!! url('/addSubFolder/"+id + "/"+lavel1+"')!!}";
         var new_url2 = "{!! url('/addDocumentfile/"+id + "/"+lavel1+"')!!}";         
         $("#addSubFolder").attr('href',new_url);         
         $("#addDocumentfile").attr('href',new_url2);


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

                //

                if(data.folder_images!='')
                { 
                    var images= '';
                    $(data.folder_images).each(function(index,value){ 
                      images+=" <div class='col-md-2' id='images_"+value.id+"'><img src='"+value.img_url+"' class='folder-img' alt='"+value.notes+"'/><p>  <span>"+value.name+"</span>  <i class='fa fa-times pull-right delete' aria-hidden='true' data="+value.id+"></i> <a href='{!! url('/downloadsDoc/"+value.id + "')!!}'> <i class='fa fa-download' aria-hidden='true'></i></a>  </p> </div>";
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

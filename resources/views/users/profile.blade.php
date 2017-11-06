@extends('master')

@section('content')

<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="#">Profile</a></li>
</ol>
<h4 class="page-title">{{ Auth::user()->name }} {{ Auth::user()->surname}}</h4>

<div class="block-area">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="tile-light p-5 m-b-15">
                                <div class="cover p-relative">
                                    <img src="img/cover-bg.jpg" class="w-100" alt="">
                                    <img class="profile-pic" src="{{ Auth::user()->profile_picture }}" alt="">
                                    {!! Form::open(['url' => 'editProfilePic', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addCaseFileForm",'files' => 'true' ]) !!}
                                    <div class="profile-btn">
                                        <input type="file" style="width: 0.1px;height: 0.1px;opacity: 0;overflow: hidden;position: absolute;z-index: -1;" name="profile_picture" id="file" class="inputfile" />
                                        <label for="file"><i style="cursor: pointer;" class="glyphicon glyphicon-camera"></i></label>
                                        <input type="submit" value="Save" name="">
                                    </div>
                                  {!! Form::close() !!}
                                </div>
                                <div class="p-5 m-t-15" style="height: 20%;">
                                  
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Works -->
                                <div class="col-md-12">
                                    <!-- Friends -->
                            <div class="tile">
                                <h2 class="tile-title">My Address Book
                                <div class="pull-right">
                                    <a href="" class="tooltips tile-menu" title="" data-original-title="Add New">
                                      <i class="fa fa-plus glyphicon glyphicon-email"></i>
                                    </a>
                                    
                                </div>
                                </h2>
                                
                                <div class="listview narrow">
                                    <div class="media p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/1.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">Mitchell Christein</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/2.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">David Villa</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media" p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/3.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">The Iron man Jr.</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media" p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/4.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">Stephen Elop</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media" p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/5.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">Wendy wenkitson</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media p-5 text-center l-100">
                                        <a href=""><small>VIEW ALL</small></a>
                                    </div>
                                </div>
                            </div>
                                    
                                   
                                    
                                </div>
                                
                                
                        
                            </div>
                            
                        </div>
                        
                        <div class="col-md-3">
                            

                            <div class="tile">
  <h2 class="tile-title">
      BASIC INFO  
      <div class="pull-right" onclick="location.href='edit-profile'" style="cursor: pointer;">
        <i class="glyphicon glyphicon-pencil" style="margin-right: 3px; "></i>EDIT                     
      </div>              
  </h2>

  <div class="listview narrow">
      <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">First Name</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->name }}
          </div>
      </div>

    <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Last Name</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->surname }}
          </div>
      </div>

       <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Preffered Language</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->name }}
          </div>
      </div>

       <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">ID Number</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->id_number }}
          </div>
      </div>
   </div>                 
</div>

<div class="tile">
  <h2 class="tile-title">
      CONTACT INFO
      <div class="pull-right" onclick="location.href='edit-profile'" style="cursor: pointer;">
        <i class="glyphicon glyphicon-pencil" style="margin-right: 3px; "></i>EDIT                     
      </div>               
  </h2>

  <div class="listview narrow">
      <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Cell Number</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->cellphone }}
          </div>
      </div>

    <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Alternative Cell</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->alt_cellphone }}
          </div>
      </div>

       <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Email</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->email }}
          </div>
      </div>

       <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Alternative Email</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->alt_email }}
          </div>
      </div>
   </div>                    
</div>

<div class="tile">
  <h2 class="tile-title">
      ADDRESS DETAILS 
     <div class="pull-right" onclick="location.href='edit-profile'" style="cursor: pointer;">
        <i class="glyphicon glyphicon-pencil" style="margin-right: 3px; "></i>EDIT                     
      </div>              
  </h2>

  <div class="listview narrow">
    <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Street Number</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->street_number }}
          </div>
      </div>

       <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Route</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->route }}
          </div>
      </div>

       <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Locality</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->locality }}
          </div>
      </div>

      <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Area</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->alt_email }}
          </div>
      </div>
      <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Postal Code</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->postal_code }}
          </div>
      </div>
      <div class="media">
          <div class="media-body pull-left">
            <a  style="margin-top: 3px;">Country</a>
          </div>
          <div class="media-body pull-right">
           {{ Auth::user()->country }}
          </div>
      </div>
   </div>                    
</div>
                            <!-- About Me 
                            <div class="tile">
                                <h2 class="tile-title">About me</h2>
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tooltips tile-menu" title="" data-original-title="Options"></a>
                                    <ul class="dropdown-menu pull-right text-right"> 
                                        <li><a href="">Edit</a></li>
                                        <li><a href="">Delete</a></li>
                                    </ul>
                                </div>
                                
                                <div class="listview icon-list">
                                    <div class="media">
                                        <i class="icon pull-left">&#61744</i>
                                        <div class="media-body">HOD Siyaleader</div>
                                    </div>
                                    
                                    <div class="media">
                                        <i class="icon pull-left">&#61753</i>
                                        <div class="media-body">Studied at UNISA</div>
                                    </div>
                                    
                                    <div class="media">
                                        <i class="icon pull-left">&#61713</i>
                                        <div class="media-body">Lives in Durban, South Africa</div>
                                    </div>
                                    
                                    <div class="media">
                                        <i class="icon pull-left">&#61742</i>
                                        <div class="media-body">From Glenwood, Durban</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Friends 
                            <div class="tile">
                                <h2 class="tile-title">Connections</h2>
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tooltips tile-menu" title="" data-original-title="Options"></a>
                                    <ul class="dropdown-menu pull-right text-right"> 
                                        <li><a href="">Edit</a></li>
                                        <li><a href="">Delete</a></li>
                                    </ul>
                                </div>
                                
                                <div class="listview narrow">
                                    <div class="media p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/1.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">Mitchell Christein</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/2.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">David Villa</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media" p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/3.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">The Iron man Jr.</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media" p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/4.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">Stephen Elop</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media" p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/5.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href="">Wendy wenkitson</a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">Unfriend</small></a>
                                        </div>
                                    </div>
                                    <div class="media p-5 text-center l-100">
                                        <a href=""><small>VIEW ALL</small></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Photos 
                            <div class="tile">
                                <h2 class="tile-title">Photos</h2>
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tooltips tile-menu" title="" data-original-title="Options"></a>
                                    <ul class="dropdown-menu pull-right text-right"> 
                                        <li><a href="">Edit</a></li>
                                        <li><a href="">Delete</a></li>
                                    </ul>
                                </div>
                                
                                <div class="p-5 photos">
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/1.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/2.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/3.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/4.jpg"  alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/5.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/6.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/2.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/5.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/1.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/3.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/4.jpg" alt="">
                                    </div>
                                    <div class="col-xs-3">
                                        <img src="img/profile-pics/6.jpg" alt="">
                                    </div>
                                    
                                    <div class="clearfix"></div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    
                    <br/><br/><br/>
                </div> 
@endsection

@section('footer')
<script>
   $(document).ready(function() {

      $("#province").change(function(){

        $.get("{{ url('/api/dropdown/districts/province')}}",
        { option: $(this).val()},
        function(data) {
        $('#district').empty();
        $('#municipality').empty();
        $('#ward').empty();
        $('#district').removeAttr('disabled');
        $('#district').append("<option value='0'>Select one</option>");
        $('#municipality').append("<option value='0'>Select one</option>");
        $('#ward').append("<option value='0'>Select one</option>");
        $.each(data, function(key, element) {
        $('#district').append("<option value="+ key +">" + element + "</option>");
        });
        });

   })

    $("#district").change(function(){
        $.get("{{ url('/api/dropdown/municipalities/district')}}",
        { option: $(this).val() },
        function(data) {
        $('#municipality').empty();
        $('#municipality').removeAttr('disabled');
        $('#municipality').append("<option value='0'>Select one</option>");
        $.each(data, function(key, element) {
        $('#municipality').append("<option value="+ key +">" + element + "</option>");
        });
        });
    });

    $("#municipality").change(function(){
        $.get("{{ url('/api/dropdown/wards/municipality')}}",
        { option: $(this).val() },
        function(data) {
        $('#ward').empty();
        $('#ward').removeAttr('disabled');
        $('#ward').append("<option value='0'>Select one</option>");
        $.each(data, function(key, element) {
        $('#ward').append("<option value="+ key +">" + element + "</option>");
        });
        });
    });

  })

</script>
@endsection

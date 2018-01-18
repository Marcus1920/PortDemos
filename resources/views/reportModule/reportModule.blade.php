@extends('master')

@section('content')
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var count =0;
    var array = new Array();
    var m = 0;
    
    function increment()
    {
      count +=1;
    } 
    //validating date
    $(document).ready(function(){
      $("#datepicker-8").datepicker({
          maxDate :-0
        });
        $("#datepicker-9").datepicker({
          maxDate :-0
        });
    });
    // Dealing with the date calender
    $(function() 
    {
            $( "#datepicker-8" ).datepicker({
               prevText:"click for previous months",
               nextText:"click for next months",
               showOtherMonths:true,
               selectOtherMonths: false
            });
            $( "#datepicker-9" ).datepicker({
               prevText:"click for previous months",
               nextText:"click for next months",
               showOtherMonths:true,
               selectOtherMonths: true
            });
    });
    //  end dealing

    function removeElement(p,c ,r)
    {
      if(c == p)
       {
          alert("this cannot be removed");
       }
      else if(document.getElementById(c))
       {
          var child = document.getElementById(c);
          var parent = document.getElementById(p);
          parent.removeChild(child);
          $('.btAdds').attr("disabled", false);
       }
      else
       {
          alert("child already removed or does not exits ");
          return false;
       }
      
       // document.getElementById(r).setAttribute("disabled", false);
    }
    // Dealing with thefunctionality of selecting a depatment button
    $(document).ready(function()
    {


      var base_url = 'http://localhost:8000/departments';
      

      $('.btAdds').click(function()
       	{
          $(this).attr("disabled", true);
          array[m] = $(this).attr("id");
          var selected_id = $(this).attr("id");
          
          m++;
          var btn_value = $(this).val();
          var selectedoptions= document.createElement('span');
          selectedoptions.setAttribute("style", "padding: 0px;margin: 0px; width : 100%;");
          var btnAdded = document.createElement("INPUT");
          btnAdded.setAttribute("type", "text");
          btnAdded.setAttribute("name", "selectedDepartment[]");
          btnAdded.setAttribute("class", "btnAdded btn-primary");
          btnAdded.setAttribute("id", ""+selected_id+"");
          btnAdded.setAttribute("value", ""+ btn_value+"");
          $(btnAdded).css(
            {
              width:'88%', height:'30px'
            });
          var btnRemove = document.createElement("span");
          // btnRemove.setAttribute("type", "button");
          btnRemove.setAttribute("class", "glyphicon glyphicon-remove-circle");

          btnRemove.setAttribute("id", "removenbtn_");
          btnRemove.setAttribute("style", "width:12%; height:25px; color:black; align:left;");
          selectedoptions.setAttribute("id", "id_");

          increment();

          btnRemove.setAttribute("onclick", "removeElement('department-selected','id_"+count+"','"+selected_id+"' )");

          selectedoptions.appendChild(btnAdded);
          selectedoptions.appendChild(btnRemove);
          selectedoptions.setAttribute("id", "id_"+count);
          document.getElementById("department-selected").appendChild(selectedoptions);
          

          
       	});
      //Add All
      $('#addAll').click(function()
        {
              $.get(base_url,function(data){
                $.each(data,function(jack,subjectB){
                    var selectedoptions= document.createElement('span');
                    selectedoptions.setAttribute("style", "padding: 0px;margin: 0px; width : 100%;");
                    var btnAdded = document.createElement("INPUT");
                    btnAdded.setAttribute("type", "text");
                    btnAdded.setAttribute("name", "selectedDepartment[]");
                    btnAdded.setAttribute("class", "btnAdded btn-primary");
                    btnAdded.setAttribute("id", ""+subjectB.id+"");
                    btnAdded.setAttribute("value", ""+ subjectB.name+"");
                    $(btnAdded).css(
                      {
                        width:'88%', height:'30px'
                      });

                    var btnRemove = document.createElement("span");
                    // btnRemove.setAttribute("type", "button");
                    btnRemove.setAttribute("class", "glyphicon glyphicon-remove-circle");

                    btnRemove.setAttribute("id", "removenbtn_");
                    btnRemove.setAttribute("style", "width:12%; height:25px; color:black; align:left;");
                    selectedoptions.setAttribute("id", "id_");

                    array[m] = subjectB.id;
                    m++;
                    increment();

                    btnRemove.setAttribute("onclick", "removeElement('department-selected','id_"+count+"')");                    
                    selectedoptions.appendChild(btnAdded);
                    selectedoptions.appendChild(btnRemove);
                    selectedoptions.setAttribute("id", "id_"+count);
                    document.getElementById("department-selected").appendChild(selectedoptions);
                });
              });
              
              $('.btAdds').attr("disabled", true);
              
        });

      //To Remove All
      $('#removeAll').click(function()
      {
        $('#department-selected').empty();
        $('.btAdds').attr("disabled", false);

      });


    });
    //end dealing
</script>

<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="#">Administration</a></li>
    <li  class="active"><a href="#">Reports</a></li>
    <li>Reports</li>
</ol>

<h4 class="page-title">Reports</h4>
<!-- Alternative -->
<div class="block-area" id="alternative-buttons">


<h3 class="block-title">Data FILTERS</h3>
<br/>
<h4 class="block-title">Data  Range</h4>
<!-- <form action="/store" method="POST"> -->
{!! Form::open(['url' => '/store', 'method' => 'POST', 'class' => 'form-horizontal', 'id'=>"filterReportsForm" ]) !!}
{!! csrf_field() !!}
   	
<div class="col col-md-6" style="height:100%; border-right: 2px solid white;">         
      <!-- date -->
      <div class="row-md-4 m-b-15">
         <p style=" color: lime-white;">Automate your Report by Specifying start and end dates</p>
           <div  class ="date-div {{ $errors->has('start') ? 'has-error': '' }}"  >
               <div class ="date-label">
                 <p>From Date:</p>
               </div>
               <div class="date-input">
                 <p><input type = "text"  name="start" placeholder ="Choose A Date" id = "datepicker-8"></p>
                 {!! $errors->first('start', '<span class="help-block" style="background-color: linen; width:60%;"><b>:message</b></span>') !!}
               </div>               
           </div>
           
            <div class="date-div {{ $errors->has('start') ? 'has-error': '' }}">
           <div class="date-label">
             <p>To Date:</p>
           </div>
           <div class="date-input">
             <p> <input type = "text" name="end" placeholder ="Pick A Date" id = "datepicker-9"></p>
               {!! $errors->first('end', '<span class="help-block" style="background-color: linen; width:60%;"><b>:message</b></span>') !!}
           </div>
         </div>
           <div class ="date-txt">
                {{--<p>(Optional)</p>--}}
               {{--<p>Last Year to Date</p>--}}
               {{--<p>Last Month</p>--}}
               {{--<p>Last Week</p>--}}
           </div>
      </div>
  
    <br/>
      
      <div class="row-md-4 m-b-15">
         <div class="sizing-row">
            <p>Company:</p>
         </div>
         <div class="predict-selection">
            
             <div id="predict">         
                @foreach($municipalit_list as $municipality)
                 <ul id="predict-list" style="list-style-type: none">
                  <input type="button" class="municipality btn-primary" id="{{ $municipality->id }}" name="municipality" value="{{ $municipality->name }}" style="width: 100%">
                 </ul>
                @endforeach 
             </div>

             <div id="predict-selected">
             </div>

             <div id="predict-btns">
                {{--<button type="button" id="predictaddAll" class="btn-primary crud">Add All</button>         --}}
                <button type="button" id="predictremoveAll" class="btn-primary crud">Remove Company</button>
             </div> 
          </div> 
      </div>
      <!-- //business unit -->
      <div class="row-md-4 m-b-15">
        <p>Department</p>
        <div class="dept-selection">

          <!-- Select buttons -->
          <div id="departments">
              <ul id="department-list"  value ="bth" style="list-style-type: none">
                <input type="button" class="btAdds btn-primary" id="department" name="dept" value="" style="width: 100%">
              </ul>
          </div>

          <div id="department-selected">
          </div>

          <!-- Options for buttons -->
          <div id="department-btns">
           {{--<button type="button" id="addAll" class="btn-primary crud">Add All</button>         --}}
           <button type="button" id="removeAll" class="btn-primary crud">Remove All</button>
         </div> 
        </div>  
      </div>
</div>

<div class="col col-md-3" style="float: center; height:100%; border-right: 2px solid white;"> 
    <div style="padding-left: 50px; ">     
       <!-- //category -->
      <div class="row-md-10 m-b-15" >
          <div class="sizing-row">
            <p>Select Category:</p>           
               <div class="p-relative {{ $errors->has('categories') ? 'has-error': '' }}" >
                <select  class ="deptCat" name="categories" id="label-f" style="background-color:#165692; color: white">
                   <option name="categoryrgt" >Select/All</option>
                </select>
                 {!! $errors->first('categories', '<span class="help-block" style="background-color: linen; width:60%;"><b>:message</b></span>') !!}
              </div>

              <!-- <select name="categories" class="p-relative">
              @foreach($categories as $key)
              <option name="category" value="{{$key->name}}">{{$key->name}}</option>
              @endforeach
            </select> -->
          </div>        
      </div> 
      <br/>
    </br/>
    <br/>
      <!-- // type repoter Graph -->
      <div class="row-md-4 m-b-15">
        <div class="sizing-row {{ $errors->has('graph') ? 'has-error': '' }}">
          <p>Select Out Put Graph Method:</p>
        
          <div class="bar-graph">
                  <div id="label-f">
                        Bar Graph 
                  </div>
                  <div id="check-box">
                     <input type="checkbox" id="case-type" name="graph[]" value="bar" style="width: 100px">
                   </div>
          </div>
          <div class="Column-graph">
                  <div  id="label-f">
                        Column Graph 
                  </div>
                  <div id= "check-box" >
                     <input type="checkbox" id="case-type" name="graph[]" value="column" style="width: 100px;">
                  </div>
          </div>
          <div class="pie-graph">
                  <div id="label-f">
                        Pie Graph 
                  </div>
                  <div id= "check-box">
                     <input type="checkbox" id="case-type" name="graph[]" value="pie" style="width: 100px">
                   </div>
          </div>
          <div class="lin-graph">
                  <div id="label-f">
                        Line Graph 
                  </div>
                  <div id= "check-box">
                     <input type="checkbox" id="case-type" name="graph[]" value="line" style="width: 100px">
                   </div>
          </div>
          {!! $errors->first('graph', '<span class="help-block" style="background-color: linen; width:60%;"><b>:message</b></span>') !!}
        </div>      
      </div>          
      
      <!-- // Over view -->
      <div class="row-md-4 m-b-15">
        <div class="sizing-row {{ $errors->has('rep_ov') ? 'has-error': '' }}">
          <p>OverView Report:</p>
          <div class="num-cases">
                  <div id="label-f">
                        No. of Cases 
                  </div>
                  <div id= "check-box">
                     <input type="checkbox" name="rep_ov[]" value="total-case" style="width: 100px">
                   </div>
          </div>
          <div class="open-cases">
                  <div  id="label-f">
                        No. of Open & Close
                  </div>
                  <div id= "check-box">
                     <input type="checkbox" name="rep_ov[]" value="total-open" style="width: 100px;">
                  </div>
          </div>
          <div class="loget-case">
                  <div id="label-f">
                        Longest To close Case
                  </div>
                  <div id= "check-box">
                     <input type="checkbox" name="rep_ov[]" value="longest-case" style="width: 100px">
                   </div>
          </div>
          <div class="short-case">
                  <div id="label-f">
                        Shotest To close Case
                  </div>
                  <div id= "check-box">
                     <input type="checkbox" name="rep_ov[]" value="short-case" style="width: 100px">
                   </div>
          </div> 
          <div class="avrg-case">
                  <div id="label-f">
                        Average To close Case
                  </div>
                  <div id= "check-box">
                     <input type="checkbox" name="rep_ov[]" value="avg-case" style="width: 100px">
                   </div>
          </div>
          {!! $errors->first('rep_ov', '<span class="help-block" style="background-color: linen; width:60%;"><b>:message</b></span>') !!}         
        </div>          
      </div>      
     </div>    
</div>

<div class="col col-md-3" style="float: right;">
  <div style="padding-left: 30px;">
      <!-- status -->
      <div class="row-md-4 m-b-15">
        <div class="sizing-row {{ $errors->has('case_repost') ? 'has-error': '' }}">
               <p>Case Status Report:</p>
          
          <div>
                @foreach($cases_statuses as $departs)
                   <div id="label-f">
                        {{ $departs->name  }} 
                   </div>
                   <div id="check-box">
                     <input type="checkbox" id="case-type" name="case_repost[]" value=" {{ $departs->name }}" style="width: 100px">
                   </div>
                @endforeach
          </div>
           {!! $errors->first('case_repost', '<span class="help-block" style="background-color: linen; width:60%;"><b>:message</b></span>') !!} 
        </div>          
      </div>
      <!-- Resonders -->
    <!--   <div class="row-md-4 m-b-15" style="margin-top:20px;">
        <div class="sizing-row {{ $errors->has('responder') ? 'has-error': '' }}">
          <p>Responder:</p>
          <div class="accepted">
                  <div id="label-f">
                        Accepted by Responder 
                  </div>
                  <div id="check-box">
                     <input type="checkbox" name="responder[]" value="accepted" style="width: 100px">
                  </div>
          </div>
          <div class="rejected">
                  <div  id="label-f">
                        Rejected by Responder  
                  </div>
                  <div id= "check-box" >
                     <input type="checkbox" name="responder[]" value="rejected" style="width: 100px">
                  </div>
          </div>
          <div class="solved">
                  <div id="label-f">
                        Case Solved by Responder 
                  </div>
                  <div id="check-box">
                     <input type="checkbox" name="responder[]" value="solved" style="width: 100px">
                  </div>
          </div>
          {!! $errors->first('responder', '<span class="help-block" style="background-color: linen; width:60%;"><b>:message</b></span>') !!}       
        </div>          
      </div> -->
      <!-- //button -->
      <div class="row-md-4 m-b-15">
            <div style="margin:10px 20px;">
                 <input type="submit" value="submit" class="btn btn-primary" style="margin:10px 20px;">
           </div>                   
      </div>
  </div>
</div>

<br/>

<br/>        
</div>
<!-- <input type="submit" id='submitFilters' class="btn btn-primary" value="Generate Report"> -->
{!! Form::close() !!}
<!-- </form> -->
</div>

<!-- end of not hidden ............................................................ -->

<!-- Responsive Table -->
<div class="block-area hidden" id="responsiveTable">


    <h3 class="block-title">Toggle columns</h3>
    <!-- Toggle column -->
    <div>
        Toggle column:
        <a class="toggle-vis" data-column="0">ID</a>
        -
        <a class="toggle-vis" data-column="1">Created At</a>
        -
        <a class="toggle-vis" data-column="2">Description</a>
        -
        <a class="toggle-vis" data-column="3">Business Unit</a>
        -
        <a class="toggle-vis" data-column="4">Precinct</a>
        -
        <a class="toggle-vis" data-column="5">Reporter</a>
        -
        <a class="toggle-vis" data-column="6">Category</a>
        -
        <a class="toggle-vis" data-column="7">Priority</a>
        -
        <a class="toggle-vis" data-column="8">Severity</a>
        -
        <a class="toggle-vis" data-column="9">Status</a>
    </div>
    <br/>

    <h3 class="block-title">Export options</h3>  
     <!-- Export options -->
    <div class="table-responsive overflow">
        <table class="table tile table-striped" id="reportsTable">
            <thead>
              <tr>
                    <th>Id</th>
                    <th>Created At</th>
                    <th>Description </th>
                    <th>Precinct</th>
                    <th>Business Unit</th>
                    <th>Reporter</th><!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="#">Administration</a></li>
    <li><a href="#">Reports</a></li>
    <li class="active">Reports</li>
</ol>

<h4 class="page-title">Reports</h4>
<!-- Alternative -->
<div class="block-area" id="alternative-buttons">

<h3 class="block-title">FILTERS</h3>
<br/>
<h4 class="block-title">Data Range</h4>

{!! Form::open(['url' => '#', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"filterReportsForm" ]) !!}
<div class="row">         
         <!-- date -->
      <div class="col-md-4 m-b-15">
          <p>From:</p>
          <div class="input-icon datetime-pick date-only">
              <input data-format="yyyy-MM-dd" type="text" id='fromDate' name ='fromDate' class="form-control input-sm" />
              <span class="add-on">
                  <i class="sa-plus"></i>
              </span>
          </div>
      </div>
      <!-- //category -->
      <div class="col-md-4 m-b-15">
          <p>Category:</p>
           <div class="p-relative">
              {!! Form::select('category',$selectCategories,0,['class' => 'form-control input-sm' ,'id' => 'category']) !!}
          </div>
      </div>
      <!-- status -->
      <div class="col-md-4 m-b-15">
          <p>Case Status Report:</p>
          <div class="p-relative">
              {!! Form::select('status',[
                                          '0'                 => 'Select / All',
                                          'Pending'           => 'Pending',
                                          'Pending Closure'   => 'Pending Closure',
                                          'Referred'          => 'Referred',
                                          'Resolved'          => 'Resolved'
                                        ],0,['class' => 'form-control input-sm' ,'id' => 'status']) !!}
          </div>
      </div>
</div>

<br/> 

<div class="row">
      <!-- //date 2 -->
    <div class="col-md-4 m-b-15">
         <p>To:</p>
         <div class="input-icon datetime-pick date-only">
             <input data-format="yyyy-MM-dd" type="text" value ="" id='toDate' name ='toDate' class="form-control input-sm" />
             <span class="add-on">
                 <i class="sa-plus"></i>
             </span>
         </div>
    </div>      
     <!-- // type repoter -->
    <div class="col-md-4 m-b-15">
          <p>Select Out Put Graph Method:</p>
           <div class="p-relative">
              {!! Form::select('typeReporter',['1' => "Tabular Report",'2' => "Pie Chart Report"],0,['class' => 'form-control input-sm' ,'id' => 'typeReporter']) !!}
          </div>
    </div>
      <!-- //Responder-->
    <div class="col-md-4 m-b-15">
          <p>Responder:</p>
           <div class="p-relative">
              {!! Form::select('reporter',$selectReporters,0,['class' => 'form-control input-sm' ,'id' => 'reporter']) !!}
          </div>
    </div>
</div>

<br/>

<div class="row">
           <!-- //predict -->
     <div class="col-md-4 m-b-15">
         <p>Precinct:</p>
          <div class="p-relative">
             {!! Form::select('precinct',$selectMunicipalities,0,['class' => 'form-control input-sm' ,'id' => 'precinct']) !!}
         </div>
     </div>

     <!-- //repoter you should put over view Report-->
     <div class="col-md-4 m-b-15">
          <p>Reporter:</p>
           <div class="p-relative">
              {!! Form::select('reporter',$selectReporters,0,['class' => 'form-control input-sm' ,'id' => 'reporter']) !!}
          </div>
     </div>

      <!-- //button -->
      <div class="col-md-4 m-b-15">
            <p></p><br/>
            <div class="p-relative">
                   <a type="#" id='submitFilters' class="btn btn-sm">Generate Report</a>
           </div>
      </div>
</div>

<br/>

<br/>
   <!-- Deaprtment -->
  <div class="row">
          <!-- // Deaprtment or business unit -->
          <div class="col-md-4 m-b-15">
          <p>Select Department or Business Unit:</p>
          <div class="p-relative">
              {!! Form::select('department',$selectDepartments,0,['class' => 'form-control input-sm' ,'id' => 'department']) !!}
          </div>
          </div>



          <!-- <div class="col-md-4 m-b-15">
              <label for"myDepartments" class="label label-primary">  
                 Choose on My Departments
              </label>
              <div class="p-relative">
                   <div class="p-relative">
                      {!! Form::select('department',$selectDepartments,0,['class' => 'form-control input-sm' ,'id' => 'department']) !!}
                    </div>
              </div>
            
          </div> -->
  </div>
{!! Form::close() !!}

</div>

<!-- Responsive Table -->
<div class="block-area hidden" id="responsiveTable">


    <h3 class="block-title">Toggle columns</h3>

    <div>
        Toggle column:
        <a class="toggle-vis" data-column="0">ID</a>
        -
        <a class="toggle-vis" data-column="1">Created At</a>
        -
        <a class="toggle-vis" data-column="2">Description</a>
        -
        <a class="toggle-vis" data-column="3">Business Unit</a>
        -
        <a class="toggle-vis" data-column="4">Precinct</a>
        -
        <a class="toggle-vis" data-column="5">Reporter</a>
        -
        <a class="toggle-vis" data-column="6">Category</a>
        -
        <a class="toggle-vis" data-column="7">Priority</a>
        -
        <a class="toggle-vis" data-column="8">Severity</a>
        -
        <a class="toggle-vis" data-column="9">Status</a>
    </div>
    <br/>

    <h3 class="block-title">Export options</h3>

    <div class="table-responsive overflow">
        <table class="table tile table-striped" id="reportsTable">
            <thead>
              <tr>
                    <th>Id</th>
                    <th>Created At</th>
                    <th>Description </th>
                    <th>Precinct</th>
                    <th>Business Unit</th>
                    <th>Reporter</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Severity</th>
                    <th>Status</th>
              </tr>
            </thead>

        </table>
    </div>

</div>

<br/>
<script>
    var count =0;
     var m = 0;
    var municipal = new Array();
    var z = 0;
    
    function increment()
    {
      count +=1;
    }        
    function removeElement(p,c)
    {
      if(c == p)
       {
          alert("this cannot be removed");
       }
      else if(document.getElementById(c))
       {
          var child = document.getElementById(c);
          var parent = document.getElementById(p);
          parent.removeChild(child);
          $('.municipality').attr("disabled", false);
       }
      else
       {
          alert("child already removed or does not exits ");
          return false;
       }
    }
    // Dealing with thefunctionality of selecting a depatment button
    $(document).ready(function()
    {
      var base_url = 'http://localhost:8000/municipalities';

      $('.municipality').click(function(e)
        {
            e.preventDefualt();

           // alert('municipality clicked');
          $(this).attr("disabled", true);
          array[m] = $(this).attr("id");
          var selected_id = $(this).attr("id");
          m++;
         
          var btn_value = $(this).val();
          console.log(btn_value);

          var selectedoptions= document.createElement('span');
          selectedoptions.setAttribute("style", "padding: 0px;margin: 0px; width : 100%;");
          var btnAdded = document.createElement("INPUT");
          btnAdded.setAttribute("type", "text");
          btnAdded.setAttribute("name", "selectedPrecict[]");
          btnAdded.setAttribute("class", "btnAdded btn-primary");
          btnAdded.setAttribute("id", "btAdded");
          btnAdded.setAttribute("value", ""+ btn_value+"");
          $(btnAdded).css(
            {
              width:'88%', height:'30px'
            });
       
          var btnRemove = document.createElement("span");
          // btnRemove.setAttribute("type", "button");
          btnRemove.setAttribute("class", "glyphicon glyphicon-remove-circle");

          btnRemove.setAttribute("id", "removenbtn_");
          btnRemove.setAttribute("style", "width:12%; height:25px; color:black; align:left;");
          selectedoptions.setAttribute("id", "id_");

          increment();

          btnRemove.setAttribute("onclick", "removeElement('predict-selected','id_"+count+"')");

          selectedoptions.appendChild(btnAdded);
          selectedoptions.appendChild(btnRemove);
          selectedoptions.setAttribute("id", "id_"+count);
          document.getElementById("predict-selected").appendChild(selectedoptions); 
        });
      //Add All
      $('#predictaddAll').click(function()
        {
                $.get(base_url,function(data){
                $.each(data,function(jack,subjectB){
                    var selectedoptions= document.createElement('span');
                    selectedoptions.setAttribute("style", "padding: 0px;margin: 0px; width : 100%;");
                    var btnAdded = document.createElement("INPUT");
                    btnAdded.setAttribute("type", "text");
                    btnAdded.setAttribute("name", "selectedPrecict[]");
                    btnAdded.setAttribute("class", "btnAdded btn-primary");
                    btnAdded.setAttribute("id", ""+subjectB.id+"");
                    btnAdded.setAttribute("value", ""+ subjectB.name+"");
                    $(btnAdded).css(
                      {
                        width:'88%', height:'30px'
                      });

                    var btnRemove = document.createElement("span");
                    btnRemove.setAttribute("class", "glyphicon glyphicon-remove-circle");

                    btnRemove.setAttribute("id", "removenbtn_");
                    btnRemove.setAttribute("style", "width:12%; height:25px; color:black; align:left;");
                    selectedoptions.setAttribute("id", "id_");

                    increment();

                    btnRemove.setAttribute("onclick", "removeElement('predict-selected','id_"+count+"')");                    
                    selectedoptions.appendChild(btnAdded);
                    selectedoptions.appendChild(btnRemove);
                    selectedoptions.setAttribute("id", "id_"+count);
                    document.getElementById("predict-selected").appendChild(selectedoptions);
                    
                });
              });
        });
      //To Remove All
      $('#predictremoveAll').click(function()
      {
        $('#predict-selected').empty();
        $('.municipality').attr("disabled", false);
      });
    });
    //end dealing
</script>
@endsection

@section('footer')

 <script>
 $(document).ready(function() 
 {
  var defaultDate = $.datepicker.formatDate('yy-mm-dd', new Date());
  $("#fromDate").val(defaultDate);
  $("#toDate").val(defaultDate);
  var oReportsTable;

  });
 $('.municipality').on('click',function()
 {
     var id =this.id;
     $('#department-list').empty();
     $.get('companyDept/'+ id,function(response)
     {
         $.each(response,function(key,value)
         {
             $('#department-list').append("<input type='button'  name='dept'  class='btAdds btn-primary' id ="+value.id+" value="+value.name+">");
         });

     });

 });

 $('#department-list').on('click',function()
 {
    var id = this.getClass();
    alert(id);
     // var inputs = document.getElementsByName("dept").childNodes;
     //    console.log(inputs);
     // for (i = 0; i < inputs.length; i++)
     // {
     //     alert(inputs);
     //     //myNodelist[i].style.backgroundColor = "red";
     // }

     $('#category-list').empty();
     $.get('deprtCategories/'+ id,function(response)
     {
         // console.log(response);
         $('#category-list').append("<option  selected disabled>Select Category</option>");
         $.each(response,function(key,value)
         {
             $('#category-list').append("<option  value="+value.id+">"+value.name+"</option>");
         });
     });
 });

 </script>
@endsection

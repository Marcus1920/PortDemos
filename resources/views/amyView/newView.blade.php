<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
</head>
<body>


    <form action="http://localhost:8000/trying" method="POST">
    {!! csrf_field() !!}
    <input type="submit" class="name"  value="create a text box"/>
    </form>


<script>
    // Dealing with thefunctionality of selecting a depatment button
    $(document).ready(function()
    {
      // creating a div for selected department list
alert('successfully injected data');
      $(document).on('click','.name',function(){


         $name = "Yanga";
      $.get('name/'+$name+'/minetrying',function(data){
        alert('successfully injected data');
      });
    });
      //      var name_id = $(this).val();
      //      var i = $('input').size() + 1;                
      //      var base_url = 'http://localhost:8000/departments';

      //      $.get(base_url,function(data){
      //        alert("success"); 

      //         $.each(data,function(jack,subjectB){

      //         $('<div><input type="text" id="name" class="name" name="name' + i +'" placeholder="Input '+subjectB.name+'"/> class="add" id="remove" /> </div>').appendTo(myForm);
        
      //   i++;
      //      });
      // });
     

      // $.post('http://localhost:8000/trying',{
      //     '_token': $('meta[name=csrf-token]').attr('content'),
      //     'name': $name
      //   }).done(function(){

      //     alert("successfully dransmitted data to a controller");

      //     }).fail(function(){alert("failed to ")});
      //   alert($name);
      //   });
      // // function udateDb(news)
      // {
      //   $post('http://localhost:8000/myTrying',{
      //     _token: $('meta[name=csrf-token]').attr('content'),
      //     newLat: newLat
      //   }).done(function(){alert("successfully dransmitted data to a controller");}).fail(function(){alert("failed to ")});
      // }
      // });
    //end dealing
</script>
</body>
</html>
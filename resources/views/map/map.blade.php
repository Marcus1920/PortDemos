@extends('master')
@section('content')

    @include('cases.profile')

@include('cases.closeRequest')
@include('addressbook.list')



    <!-- Breadcrumb -->
    <ol class="breadcrumb hidden-xs">
        <li><a href="#">Administration</a></li>
        <li class="active">Map</li>
    </ol>

    <div id="mapBlockDiv" class="block-area">

        <div class="tile" style="height:800px">

            <div class="tile-config dropdown">
                <a data-toggle="dropdown" href="" class="tile-menu"></a>
                <ul class="dropdown-menu pull-right text-right">


                    <li><a href="javascript:void()" onclick="document.getElementById('googleMap').src='map.php'">Refresh</a></li>

                   <!-- <li><a href="javascript:void()" onclick="document.getElementById('googleMap').src='../map.php'">Refresh</a></li>   -->


                </ul>
            </div>

            <input id="userID" type="hidden" value="{{ Auth::user()->id }}" />



            <iframe id="googleMap" src="../map.php" MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=auto HSPACE=0 VSPACE=0 NORESIZE frameborder=0 style="width:100%;height:100%;" allowFullScreen></iframe>

        </div>
    </div>


@endsection

@section('footer')

@endsection

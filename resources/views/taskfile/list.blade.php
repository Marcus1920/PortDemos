<div class="listview narrow">

    @foreach($taskFiles as $taskFile)
        <div class="media p-l-5">
            <div class="pull-left">

                <a href="#">

                    <i class="fa fa-trash-o fa-2x"></i>

                </a>

                <a href="{{ asset( $taskFile->img_url ) }}"  download="{{ $taskFile->file }}">

                    <i class="fa fa-paperclip fa-2x"></i>

                </a>

            </div>
            <div class="media-body">
                NOTE  : {{ $taskFile->file_note }} <br/>

                @if (pathinfo($taskFile->file, PATHINFO_EXTENSION) == 'png' || pathinfo($taskFile->file, PATHINFO_EXTENSION) == 'jpg' || pathinfo($taskFile->file, PATHINFO_EXTENSION) == 'PNG' || pathinfo($taskFile->file, PATHINFO_EXTENSION) == 'jpeg' )

                    <a href="{{ asset( $taskFile->img_url ) }}" data-rel="gallery"  class="pirobox_gall img-popup" title="{{ $taskFile->file_note }}">

                        FILE  : {{ $taskFile->file }}

                    </a>


                @else

                     FILE  : {{ $taskFile->file }}

                @endif



            </div>
        </div>
    @endforeach

</div>

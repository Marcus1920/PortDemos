@extends('master')

@section('content')
    <!-- Breadcrumb -->
    <ol class="breadcrumb hidden-xs">
        <li><a href="#">Administration</a></li>
        <li><a href="{{ url('list-statuses') }}">Task Categories</a></li>
        <li class="active">Categories Listing</li>
    </ol>

    <h4 class="page-title">Task Categories</h4>
    <!-- Alternative -->
    <div class="block-area" id="alternative-buttons">
        <h3 class="block-title">Add a new task category</h3>
    </div>


    <div class="block-area">

        @if(Session::has('message'))

            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>

        @endif

        {!! Form::open(['url' => 'add-task-category', 'method' => 'post', 'class' => 'form-inline' ]) !!}
        {!! Form::hidden('id',Auth::user()->id) !!}

            <div class="form-group">
                {!! Form::label('name', 'name', array('class' => 'sr-only')) !!}
                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                {!! Form::text('name',NULL,['class' => 'form-control input-sm','id' => 'name','placeholder' => 'Category Name']) !!}
            </div>

            <div class="form-group">

                <div class="color-pick input-icon">
                    {!! Form::text('color',NULL,['class' => 'form-control color-picker input-sm','id' => 'name','placeholder' => 'Choose Color']) !!}
                    <span class="color-preview"></span>
                    <span class="add-on"><i class="sa-plus"></i></span>
                </div>

            </div>
            <div class="form-group">

                <button class="btn btn-sm">
                    <i class="fa fa-plus" aria-hidden="true" title="Add Your New Task Here" data-toggle="tooltip"></i>
                </button>
            </div>

        {!! Form::close() !!}

    </div>
    <div class="block-area">

        @foreach($taskCategories as $taskCategory)

            {!! Form::open(['url' => 'add-task-category', 'method' => 'post', 'class' => 'form-inline' ]) !!}

            <div class="form-group">
                {!! Form::label('name', 'name', array('class' => 'sr-only')) !!}
                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                {!! Form::text('name',$taskCategory->name,['class' => "form-control input-sm color_name_id_$taskCategory->id",'id' => 'name']) !!}
            </div>

            <div class="form-group">

                <div class="color-pick input-icon">
                    <input class="form-control color-picker input-sm color_id_{{ $taskCategory->id }}" id="name" placeholder="Choose Color" name="color" type="text" value="{{ $taskCategory->color }}">
                    <span class="color-preview" style="background: {{ $taskCategory->color }};"></span>
                    <span class="add-on"><i class="sa-plus"></i></span>
                </div>

            </div>

            <div class="form-group">
                <a  href="#" onclick="editTaskCategory({{ $taskCategory->id }})"> <i class="fa fa-edit" aria-hidden="true" title="Edit Task Category" data-toggle="tooltip"></i> </a>
                <a href="{{ url('delete-task-category/'.$taskCategory->id.'') }}"> <i class="fa fa-minus-circle" aria-hidden="true" title="Delete Task Category" data-toggle="tooltip"></i> </a>

            </div>

            {!! Form::close() !!}

        @endforeach


    </div>

    @include('statuses.edit')
    @include('statuses.add')
@endsection

@section('footer')

    <script>

       function editTaskCategory(id){

           var task_category_id = id;
           var color_name       = $(".color_name_id_"+ id).val();
           var color_code       = $(".color_id_"+ id).val()
           var formData         =  { color_name : color_name,color_code : color_code,task_category_id:task_category_id};

           $.ajax({
               type    :"GET",
               data    : formData,
               url     :"{!! url('/edit-task-category')!!}",
               success : function(data){

               }
           });

       }

    </script>
@endsection

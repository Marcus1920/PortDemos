 <!-- Inline -->
 <div class="row">

     <div class="block-area" id="inline">

         {!! Form::open(['url' => 'task-notes', 'method' => 'post', 'class' => 'form' ]) !!}
         {!! Form::hidden('id',Auth::user()->id) !!}
         {!! Form::hidden('activity_note','added a note') !!}
         <input type="hidden" name="task_id" value="{{ $task->id }}">

         <div class="form-group">
             <label for="inputMessage" class="col-md-2 control-label">Notes</label>
             <div class="col-md-10">
            <textarea class="form-control  input-sm"  rows="5"  id="note" rows="5" name="note">



            </textarea>
                 @if ($errors->has('notes')) <p class="help-block red">*{{ $errors->first('notes') }}</p> @endif
             </div>
         </div>
         <div class="form-group">
             <div class="col-md-offset-2 col-md-10">
                 <button type="submit" class="btn btn-info btn-sm m-t-10">ADD NOTE</button>
             </div>
         </div>
         {!! Form::close() !!}
     </div>

 </div>

 <hr class="whiter m-t-20" />

 <br/>
 <br/>





<?php

namespace App\Services;

use App\TaskFile;
use App\Http\Requests;
use Auth;
use Illuminate\Http\Response;
use File;


class TaskFileService
{
    public function getFiles()
    {
        return TaskFile::all();
    }

    public function createTaskFile($request )
    {

        //TODO : add delete button
        //TODO :

        $destinationFolder = 'files/tasks/task_' . $request['task_id'];

        if (!file_exists($destinationFolder)) {

            File::makeDirectory($destinationFolder, 0775, true,true);

        }

        $fileName     = $request->file('file')->getClientOriginalName();
        $fileFullPath = $destinationFolder . '/' . $fileName;

        if (File::exists($destinationFolder))
        {
            $request->file('file')->move($destinationFolder, $fileFullPath);
            $taskFile               = New TaskFile();
            $taskFile->task_id      = $request['task_id'];
            $taskFile->file         = $fileName;;
            $taskFile->file_note    = $request['file_note'];
            $taskFile->img_url      = $fileFullPath;
            $taskFile->created_by   = Auth::user()->id;
            $taskFile->save();

            return $taskFile;
        }


    }



}
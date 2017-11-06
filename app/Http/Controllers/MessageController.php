<?php

namespace App\Http\Controllers;

use App\addressbook;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use App\Events\MyEventNameHere;
use phpDocumentor\Reflection\Types\Null_;
use Redirect;
use Session;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $msgs = \DB::table('messages')
                    ->join('users', 'users.id', '=', 'messages.from')
                    ->where('messages.to','=',\Auth::user()->id)
                    ->where('messages.online','=',0)
                    ->select(
                                \DB::raw("
                                            messages.id,
                                            messages.created_at,
                                            messages.read,
                                            messages.message,
                                            CONCAT(`users`.`name`,' ',`users`.`surname`) as originator
                                        ")
                            )
                    ->orderBy('messages.created_at','desc')
                    ->get();

        return view('messages.list-all',compact('msgs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request)
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $caseMessage           = new Message();
        $caseMessage->from     = $request['uid'];
        $caseMessage->to       = $request['to'];
        $caseMessage->online   = 0;
        $caseMessage->case_id  = $request['caseID'];
        $caseMessage->message  = $request['msg'];
        $caseMessage->subject  = $request['msgSubject'];
        $caseMessage->active   = 1;
        $caseMessage->save();

        $user = User::find($request['to']);

        $data = array(
                    'name'        =>$user->name,
                    'caseID'      =>$request['caseID'],
                    'sender'      => \Auth::user()->name.' '.\Auth::user()->surname,
                    'msg'         =>$request['msg'],
                    );


        \Mail::send('emails.privateMessage',$data, function($message) use ($user)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($user->email)->subject("Siyaleader Notification - New Private Message: ");

       });

        $data =  array (

                'type'    => 'noUnreadprivatemsg',
                'dest'    => $request['to']

        );

        event(new MyEventNameHere($data));

        return 'ok';

    }

    public function storeEmail(Request $request)
    {
        $user = addressbook::find($request['Recepient']);

        $user_exist = User::where('email',$user->email,'=')->first();

        $caseMessage           = new Message();
        $caseMessage->from     = $request['uid'];

        if($user_exist!=NULL)
        {
            $caseMessage->to = $user_exist->id;
        }
        else
        {
            $caseMessage->to       = $request['Recepient'];
        }
        $caseMessage->online   = 0;
        $caseMessage->case_id  = $request['caseID'];
        $caseMessage->message  = $request['msg'];
        $caseMessage->subject  = $request['msgSubject'];
        $caseMessage->active   = 1;
        $caseMessage->save();

        $data = array(
            'name'        =>$user->first_name,
            'caseID'      =>$request['caseID'],
            'sender'      => \Auth::user()->name.' '.\Auth::user()->surname,
            'msg'         =>$request['msg'],
        );

        \Mail::send('emails.privateMessage',$data, function($message) use ($user)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($user->email)->subject("Siyaleader Notification - New Private Message: ");

        });

        if($request['Cc']!=NULL)
        {
            $Ccs=explode(",",$request->Cc);

            for($i=0 ; $i < count($Ccs) ; $i++)
            {
                $user = addressbook::find($Ccs[$i]);

                $data = array(
                    'name'        =>$user->first_name,
                    'caseID'      =>$request['caseID'],
                    'sender'      => \Auth::user()->name.' '.\Auth::user()->surname,
                    'msg'         =>$request['msg'],
                );


                \Mail::send('emails.privateMessage',$data, function($message) use ($user)
                {
                    $message->from('info@siyaleader.net', 'Siyaleader');
                    $message->to($user->email)->subject("Siyaleader Notification - New Private Message: ");

                });
            };

            \Session::flash('success', 'Email has been successfully sent!');
            return Redirect::to('casetest/'.$request['caseID']);
        }
        else
        {
            \Session::flash('success', 'Email has been successfully sent!');
            return Redirect::to('casetest/'.$request['caseID']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $msgObj = Message::find($id);
        $msgObj->read = 1;
        $msgObj->save();
        $data =  array (

                'type'    => 'noreadprivatemsg',
                'dest'    => $msgObj->to,

        );

        event(new MyEventNameHere($data));
        $sender = User::find($msgObj->from);
        return view('messages.detail',compact('msgObj','sender'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

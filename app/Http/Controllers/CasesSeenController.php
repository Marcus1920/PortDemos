<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CasesSeenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$txtDebug = __CLASS__."".__FUNCTION__."(Request \$request)";
		$txtDebug .= PHP_EOL."  \$request - ".print_r($request->all(), 1);
		$cid = array_key_exists("cid", $request->all()) ? $request->all()['cid'] : 0;
		$uid = array_key_exists("uid", $request->all()) ? $request->all()['uid'] : 0;
		$res = array('status'=>-1,'msg'=>array());
		//$data = \App\CasesSeen::firstOrNew(array('cid'=>$cid,'uid'=>$uid));
		$data = \App\CasesSeen::where(array('cid'=>$cid,'uid'=>$uid));
		try {
			$data->delete();
			$res['status'] = 1;
		} catch (Exception $ex) {
			$res['status'] = 0;
			$res['msg'][] = "Error deleting";
		}
		foreach ($data AS $di=>$d) {
			$txtDebug .= "\n  \$di - {$di}, {$d}";
		}
		
		$txtDebug .= PHP_EOL."  \$data - ".print_r($data->get(), 1);
		$txtDebug .= PHP_EOL."  count - ".$data->count();
		$dataNew = (new \App\CasesSeen())->newInstance(array('cid'=>$cid,'uid'=>$uid));
		///$data->setAttribute("when", date("Y-m-d"));
		try {
			$dataNew->save();
			$res['status'] = 1;
		} catch (Exception $ex) {
			$res['status'] = 0;
			$res['msg'][] = "Error saving";
		}
		$txtDebug .= PHP_EOL."  \$res - ".print_r($res, 1);
die("<pre>{$txtDebug}</pre>");
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
        //
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
	
	public function switchSeen(Request $request) {
		$txtDebug = __CLASS__."".__FUNCTION__."(Request \$request)";
		$txtDebug .= PHP_EOL."  \$request - ".print_r($request->all(), 1);
		$cid = array_key_exists("cid", $request->all()) ? $request->all()['cid'] : 0;
		$uid = array_key_exists("uid", $request->all()) ? $request->all()['uid'] : 0;
		$res = array('status'=>-1,'msg'=>array(),'img'=>"");
		//$data = \App\CasesSeen::firstOrNew(array('cid'=>$cid,'uid'=>$uid));
		$data = \App\CasesSeen::where(array('cid'=>$cid,'uid'=>$uid));
		if ($data->count() > 0) {
			try {
				$data->delete();
				$res['status'] = 1;
				$res['img'] = "unseen";
			} catch (Exception $ex) {
				$res['status'] = 0;
				$res['msg'][] = "Error deleting";
				$res['img'] = "seen";
			}
		} else {
			$dataNew = (new \App\CasesSeen())->newInstance(array('cid'=>$cid,'uid'=>$uid));
			try {
				$dataNew->save();
				$res['status'] = 1;
				$res['img'] = "seen";
			} catch (Exception $ex) {
				$res['status'] = 0;
				$res['msg'][] = "Error saving";
				$res['img'] = "unseen";
			}
		}
		$txtDebug .= PHP_EOL."  \$data - ".print_r($data->get(), 1);
		$txtDebug .= PHP_EOL."  count - ".$data->count();
		
		///$data->setAttribute("when", date("Y-m-d"));
		return $res;
		$txtDebug .= PHP_EOL."  \$res - ".print_r($res, 1);
die("<pre>{$txtDebug}</pre>");
}
}

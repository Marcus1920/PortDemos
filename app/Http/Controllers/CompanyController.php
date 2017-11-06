<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data = \DB::table('companies')
			->select(
				\DB::raw("
					companies.id
					, companies.created_at
					, companies.name
					, (select count(*) from departments where company = companies.id) AS cntDepartments
        ")
			);

		return \Datatables::of($data)
			->addColumn('actions', '<a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchCompanyModal({{$id}});" data-target=".modalEditCompany">Edit</a>')
			->make(true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$data    = \App\Company::where('id',$id)->first();
		return [$data];
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id = null) {
		$txtDebug = __CLASS__."".__FUNCTION__."(\$request, \$id) \$id - {$id}, \$request - ".print_r($request->all(),1);

		if ($id == null) $id = $request['id'];
		$txtDebug .= "\n  \$id - {$id} (empty - ".empty($id).")";

		$item = null;
		if (empty($id)) {
			$txtDebug .= "\n  Creating new company";
			$item = new \App\Company();
		} else {
			$txtDebug .= "\n  Updating existing company";
			$item = \App\Company::find($id);
		}
		$item->fill($request->all());
		$saved = $item->save();
		$txtDebug .= "\n  \$item - ".print_r($item,1);
		//die("<pre>{$txtDebug}</pre>");
		\Session::flash('success', 'well done! company '.$request['name'].' has been successfully updated!');
		return redirect("list-companies");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}

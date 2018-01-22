<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Permission;
use App\GroupPermission;
use App\Http\Requests\PermissionsRequest;

class PermissionController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$permissions = \DB::table('permissions')
			->select(
				\DB::raw(
					"
                                         permissions.id,
                                         permissions.title,
                                         permissions.name,
                                         permissions.data
                                        "
				)
			);


		return \Datatables::of($permissions)
			->addColumn('actions', '<a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchPermissionsModal({{$id}});" data-target=".modalEditPermission">Edit</a>')
			->make(true);

	}

	public function group_users_list($id) {
		$users = \DB::table('users')
			->where('role', $id)
			->select(
				\DB::raw(
					"
                                         users.id,
                                         users.name
                                        "
				)
			);


		return \Datatables::of($users)
			->make(true);

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function edit($id) {

		$permission = Permission::where('id', $id)->first();
		return [$permission];
	}

	/*function listPermissions($filter = "", $gid = 0, $uid = 0) {
		$txtDebug = __CLASS__ . "->" . __FUNCTION__ . "(\$filter,\$gid,\$uid) \$gid - {$gid}, \$uid - {$uid}, \$filter - {$filter}";*/
	function listPermissions($gid = 0) {
		$txtDebug = __CLASS__ . "->" . __FUNCTION__ . "(\$gid) \$gid - {$gid}";
		$filter = array_key_exists("filter", $_REQUEST) ? $_REQUEST['filter'] : "assigned";
		$txtDebug .= PHP_EOL . "  \$filter - {$filter}, Request - " . print_r($_REQUEST, 1);
		$data = \DB::table("permissions");//->orderBy("name");
		$list = json_encode(json_decode("{}"));
		if ($gid == 0) $list = $this->index();
		else {
			if (in_array($filter, array("", "all", "assigned"))) {
				//if ( in_array($filter, array("", "1")) ) {
				$data = \DB::table('group_permissions AS gp')
					->where('group_id', '=', $gid)
					->join('permissions', 'permissions.id', '=', 'gp.permission_id')
					///->select(\DB::raw("gp.id, permissions.name, permissions.id AS perm_id, permissions.title"));
					//->select( \DB::raw("GROUP_CONCAT(gp.id SEPARATOR \";\") AS id, permissions.name, permissions.id AS perm_id, gp.group_id") )
					->select(\DB::raw("GROUP_CONCAT(gp.id) AS id, permissions.name, permissions.id AS perm_id, gp.group_id"))
					->groupBy('gp.group_id', 'gp.permission_id')
					//->groupBy('gp.id')
					->orderBy("name");;
			} else if (in_array($filter, array("unassigned"))) {
				$assigned = \DB::table('permissions AS perms')->select(\DB::raw("perms.id"))->get("id");
				$txtDebug .= PHP_EOL . "  \$assigned - " . print_r($assigned, 1);
				$data = \DB::table('permissions AS perms')
					/*->whereNotIn('perms.id', function($query) {
						$txtDebug = __CLASS__ . "->" . __FUNCTION__ . "(\$query) \$gid - , \$query - ".print_r($query->get()->toArray());
						//die("<pre>{$txtDebug}</pre>");
						$gid = 0;
						//\DB::select("group_permissions AS gp");//->where("gp.group_id", $gid);
						//\DB::table("group_permissions AS gp")->select("id");//->where("gp.group_id", $gid);
						return array(1,2,3,4,5);
						//return $query->select("permission_id")->from("group_permissions AS gp")->where("gp.group_id", $gid);
					})*/
					//->whereNotIn("perms.id", $assigned)
					->whereRaw("perms.id NOT IN (SELECT permission_id FROM group_permissions AS gp WHERE gp.group_id = {$gid})")
					//->join('permissions','permissions.id','=','gp.permission_id')
					->select(\DB::raw("perms.id, perms.name, perms.title"));
			}
			$txtDebug .= PHP_EOL . "  \$data SQL - " . print_r($data->toSql(), 1);
			$data = $data->get();
			$data_grouped = array();
			$txtDebug .= "\n  Grouping data";
			foreach ($data AS $d) {
				$s = preg_split('/[.-]/', $d->name);
				if (count($s) > 1) {
					if (!array_key_exists($s[1], $data_grouped)) {
						$data_grouped[$s[1]] = array();
					}
					$data_grouped[$s[1]][] = $d;
				}
			}
			//uksort($data_grouped, function($a,$b) { return strcasecmp($a, $b); });
			ksort($data_grouped);
			$txtDebug .= PHP_EOL . "  \$data_grouped - " . print_r($data_grouped, 1);
			$data = array();
			foreach ($data_grouped AS $gi=>$gd) {
				uasort($gd, function($a,$b) {
					return strcasecmp($a->name, $b->name);
				});
				foreach ($gd AS $d) {
					$data[] = $d;
				}
			}
			$txtDebug .= "\n  Sorting data";
			/*uasort($data, function($a, $b) {
				$txtDebug = "\n  \$a - {$a->name}, \$b - {$b->name}";
				$s = array();
				$s[0] = preg_split('/[.-]/', $a->name);
				$s[1] = preg_split('/[.-]/', $b->name);
				$txtDebug .= "\n    \$s - ".print_r($s,1);
				echo $txtDebug;
				if (count($s[0]) > 1 && count($s[1]) > 1) {

					if ($s[0][1] == $s[1][1]) return 0;
					else return strcmp($s[0][0], $s[1][0]);
				}
				else return 0;
			});*/
			//uasort($data, function($a,$b) { return strcmp($a->name, $b->name); });
			$txtDebug .= PHP_EOL . "  \$data - " . print_r($data, 1);
			//die("<pre>{$txtDebug}</pre>");
			$list = \Datatables::of(collect($data))->make(true);
		}
		//die("<pre>{$txtDebug}</pre>");
		return $list;
	}

	function list_permissions($id) {

		$groupPermissions = \DB::table('group_permissions')
			->where('group_id', '=', $id)
			->join('permissions', 'permissions.id', '=', 'group_permissions.permission_id')
			->select(
				\DB::raw("
                                        group_permissions.id,
                                        permissions.name


                                    "
				)
			)
			->groupBy('group_permissions.id');

		return \Datatables::of($groupPermissions)
			->make(true);


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request) {
		$this->validate($request, [
			'name' => 'required|unique:permissions'
		]);
		//$permission = Permission::where('id', $request['permissionId'])->first();
		$permission = Permission::findOrNew($request['permissionId']);
		$permission->name = $request['name'];
		$permission->title = $request['title'];
		$db = $request['db'];
		$ddd = "";
		if ($db['table']) {
			$ddd = $db['table'];
			if ($db['field']) $ddd .= ".{$db['field']}";
		}
		$permission->data = $ddd;
		$permission->updated_by = \Auth::user()->id;
		$permission->save();
		\Session::flash('success', 'well done! permission ' . $request['name'] . ' has been successfully updated!');
		return redirect()->back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */


	public function show() {

		$searchString = \Input::get('q');
		$permissions = \DB::table('permissions')
			->whereRaw("CONCAT(`name`) LIKE '%{$searchString}%'")
			->select(\DB::raw('*'))
			->get();

		$data = array();

		if (count($permissions) > 0) {

			foreach ($permissions as $permission) {
				$data[] = array("name" => "{$permission->name}", "id" => "{$permission->id}", "name" => "{$permission->name}");
			}


		}


		return $data;

	}


	public function storeGroupPermissions(Request $request) {


		$response = array();

		$permissions = $request->get('checkbox-1');

		foreach ($permissions as $permission) {


			$groupPermission = new groupPermission();
			$groupPermission->group_id = $request['groupID'];
			$groupPermission->permission_id = $permission;
			$groupPermission->created_by = \Auth::user()->id;
			$groupPermission->save();


		}

		$response["message"] = "Permission Added!";
		$response["error"] = FALSE;
		$response["groupID"] = $request['groupID'];

		return \Response::json($response, 201);


	}

	public function removeGroupPermission(Request $request) {


		$response = array();

		foreach ($request['arr'] as $value) {

			$groupPermission = GroupPermission::find($value);
			$groupPermission->delete();

		}

		$response["message"] = "Group Permission Deleted!";
		$response["error"] = FALSE;
		$response["groupID"] = $request['id'];

		return \Response::json($response, 201);

	}

	public function updateGroupPermissions(Request $req) {
		$txtDebug = __CLASS__ . "->" . __FUNCTION__ . "(\$req) \$req - " . print_r($req->all(), 1);
		$gid = array_key_exists("gid", $req->all()) ? $req->all()['gid'] : 0;
		$assign = array_key_exists("chk_unassigned", $req->all()) ? $req->all()['chk_unassigned'] : array();
		$unassign = array_key_exists("chk_assigned", $req->all()) ? $req->all()['chk_assigned'] : array();
		$txtDebug .= PHP_EOL . "  \$gid - " . print_r($gid, 1);
		$txtDebug .= PHP_EOL . "  \$assign - " . print_r($assign, 1);
		$txtDebug .= PHP_EOL . "  \$unassign - " . print_r($unassign, 1);
		$txtDebug .= PHP_EOL . "  Assigning";
		foreach ($assign AS $i => $id) {
			$txtDebug .= PHP_EOL . "    \$i - " . print_r($id, 1);
			$perm = GroupPermission::where("group_id", $gid)->where("permission_id", $id);
			$txtDebug .= ", count - " . ($perm ? $perm->get()->count() : 0);
			//$txtDebug .= ", sql - ".print_r($perm->toSql(), 1);
			//$txtDebug .= ", binding - ".print_r($perm->getBindings(), 1);
			if ($perm->get()->count() == 0) {
				//GroupPermission::create(array('id'=>null, 'group_id'=>$gid, 'permission_id'=>$id));
				$newperm = GroupPermission::create();
				$newperm->forceFill(array('group_id' => $gid, 'permission_id' => $id, 'created_by' => \Auth::user()->id, 'updated_by' => \Auth::user()->id));
				$newperm->save();
			}
		}
		$txtDebug .= PHP_EOL . "  UnAssigning";
		foreach ($unassign AS $i => $id) {
			$txtDebug .= PHP_EOL . "    \$i - " . print_r($id, 1);
			$perm = GroupPermission::where("id", $id);//->where("group_id",$gid);//->where("permission_id", $id);
			//$perm = GroupPermission::where("group_id",$gid)->where("permission_id", $id);
			$txtDebug .= ", count - " . ($perm ? $perm->get()->count() : 0);
			//$txtDebug .= ", sql - ".print_r($perm->toSql(), 1);
			//$txtDebug .= ", binding - ".print_r($perm->getBindings(), 1);
			if ($perm->get()->count() > 0) $perm->delete();
		}
		return redirect()->back();
		die("<pre>{$txtDebug}</pre>");
	}


}

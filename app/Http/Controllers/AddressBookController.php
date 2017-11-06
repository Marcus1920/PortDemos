<?php
namespace App\Http\Controllers;

use App\User;
use App\UserRole;
use App\Position;
use App\UserStatus;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\AddressBookRequest;
use App\Http\Controllers\Controller;
use App\addressbook;
use Redirect;
use Session;
use Auth;

class AddressBookController extends Controller {
	private $user;

	public function __construct(User $user) {
		$this->user = $user;
	}

	public function AddressbookList() {
		$userAddUserPermission = \DB::table('group_permissions')
			->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
			->where('group_permissions.permission_id', '=', 31)
			->where('group_permissions.group_id', '=', \Auth::user()->role)
			->first();

		return view('addressbook.index', compact('userAddUserPermission'));
	}

	public function index() {
		$userEditUserPermission = \DB::table('group_permissions')
			->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
			->where('group_permissions.permission_id', '=', 32)
			->where('group_permissions.group_id', '=', \Auth::user()->role)
			->first();
		$users = \DB::table('users')
			->join('positions', 'users.position', '=', 'positions.id')
			->select(
				\DB::raw(
					"
                                         users.id,                              
                                         users.name,
                                         users.surname,
                                      
                                         users.cellphone,
                                       
                                        positions.name as position
                                        "
				)
			);

		return \Datatables::of($users)
			->addColumn('actions', '<a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchUpdateUserModal({{$id}});" data-target=".modalEditUser" >Edit</a>


                                        '
			)->make(true);
	}

	public function create() {
		return view('addressbook.add');
	}

	public function store(Request $request) {
		$txtDebug = __CLASS__."".__FUNCTION__."(\$request) \$request - ".print_r($request->all(), 1);
		$addressbook               = new addressbook();
		$addressbook->user         = $request['user'];
		$addressbook->first_name   = $request['first_name'];
		$addressbook->Surname      = $request['Surname'];
		$addressbook->email        = $request['email'];
		$addressbook->cellphone    = $request['cellphone'];
		$addressbook->created_by   = \Auth::user()->id;
		$addressbook->relationship = '';
		$addressbook->active       = 1;
		$txtDebug .= "\n  \$addressbook - ".print_r($addressbook,1);
		//die("<pre>{$txtDebug}</pre>");
		$addressbook->save();
		\Session::flash('success', $addressbook->first_name . ' ' . $addressbook->surname . ' has been  added to your Private Book Address');

		return Redirect::to('/addressbookList/' . Auth::user()->id);
	}

	public function show() {
		$searchString        = \Input::get('q');
		$addressbookContacts = \DB::table('addressbook')
			->where('user', '=', \Auth::user()->id)
			->whereRaw("CONCAT(`first_name`, ' ', `surname`, ' ', `email`) LIKE '%{$searchString}%'")
			->select(\DB::raw('*'))
			->get();
		$data = array();
		if (count($addressbookContacts) > 0) {
			foreach ($addressbookContacts as $addressbookContact) {
				$data[] = array("name" => "{$addressbookContact->first_name} {$addressbookContact->surname} <{$addressbookContact->email}", "id" => "{$addressbookContact->email}", "first_name" => "{$addressbookContact->first_name}", "surname" => "{$addressbookContact->surname}", "cellphone" => "{$addressbookContact->cellphone}", "email" => "{$addressbookContact->email}", "userId" => "{$addressbookContact->id}", "addressbook" => "1");
			}
		}
		$usersContacts = \DB::table('users')
			->join('positions', 'users.position', '=', 'positions.id')
			->whereRaw("CONCAT(`users`.`name`, ' ', `users`.`surname`, ' ', `users`.`email`,`positions`.`name`) LIKE '%{$searchString}%'")
			->select(array('users.id', 'users.name as name', 'users.surname as surname', 'users.email as username', 'users.cellphone as cellphone', 'positions.name as position'))
			->get();
		if (count($usersContacts) > 0) {
			foreach ($usersContacts as $usersContact) {
				$data[] = array("name" => "{$usersContact->name} {$usersContact->surname} << {$usersContact->position}", "id" => "{$usersContact->username}", "first_name" => "{$usersContact->name}", "surname" => "{$usersContact->surname}", "cellphone" => "{$usersContact->cellphone}", "email" => "{$usersContact->username}", "userId" => "{$usersContact->id}", "addressbook" => "0");
			}
		}

		return $data;
	}

	public function getAddressBookUsers() {
		$searchString = \Input::get('q');
		$users        = \DB::table('addressbook')
			->where('addressbook.user', '=', \Auth::user()->id)
			->whereRaw(
				"CONCAT(`addressbook`.`first_name`, ' ', `addressbook`.`surname`) LIKE '%{$searchString}%'")
			->select(
				array
				(
					'addressbook.id as id',
					'addressbook.first_name as first_name',
					'addressbook.surname as surname',
					'addressbook.email as email',
				)
			)
			->get();
		$data = array();
		foreach ($users as $user) {
			$data[] = array(
				"name" => "{$user->first_name} > {$user->surname}",
				"id"   => "{$user->id}",
			);
		}

		return $data;
	}

	public function edit($id) {
		//
	}

	public function update(Request $request, $id = null) {
		$txtDebug = __CLASS__."".__FUNCTION__."(\$request, \$id) \$id - {$id}, \$request - ".print_r($request->all(),1);
		$data          = AddressBook::where("id", $request['id'])->first();
		$txtDebug .= "\n  \$data A - ".print_r($data, 1);
		$data->setAttribute('notes',$request['notes']);
		$txtDebug .= "\n  \$data B - ".print_r($data->first(), 1);
		$txtDebug .= "\n  \$data C - ".print_r($data->get(), 1);
		//die("<pre>{$txtDebug}</pre>");
		$saved = $data->save();
		if ($saved) \Session::flash('success', "Address book updated successfully");
		else \Session::flash('error', "Problem updating address book");
		$txtDebug .= "\n  \$data: saved - ".var_export($saved,1).",".print_r($data, 1);
		$txtDebug .= "\n  SQL: {$data->toSql()}";
		return redirect('/addressbookList/' . Auth::user()->id);
		die("<pre>{$txtDebug}</pre>");
	}

	public function destroy($id) {
		//
	}

	public function display() {
		$users = \DB::table('users')
			->join('positions', 'users.position', '=', 'positions.id')
			->select(
				\DB::raw(
					"
                                         users.id,
                            
                                         users.name,
                                         users.surname,
                                      
                                         users.cellphone,
                                       
                                        positions.name as position
                                        "
				)
			)->first();

		return $users;
	}

	public function getProfilePerUser($id) {
		$txtDebug = __CLASS__."".__FUNCTION__."(\$id) \$id - {$id}";
		$users       = User::all();
		$contactBook = addressbook::where('created_by', $id)->get();//->orderBy()->get();
		$txtDebug .= "\n  \$contactBook - ".print_r($contactBook,1);
//echo("<pre>{$txtDebug}</pre>");
		return view('addressbook.view')
			->with(compact('contactBook'))
			->with(compact('users'));
	}

	public function userprofileGlobal($id) {
		$user = User::select('name', 'surname', 'email', 'cellphone', 'id')->where('id', $id)->first();

		return response()->json($user);
	}

	public function userprofilePrivate($id) {
		$contactBook = addressbook::select('id','first_name', 'surname', 'email', 'cellphone', 'user', 'notes')->where('id', $id)->first();

		return response()->json($contactBook);
	}

	public function deleteuser($id) {
		$created_by  = Auth::user()->id;
		$contactBook = addressbook::where('created_by', $created_by)
			->where('user', $id);
		$contactBook->delete();

		return Auth::user()->id;
	}
}
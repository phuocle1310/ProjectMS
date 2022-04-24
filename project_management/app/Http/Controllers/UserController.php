<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\DeleteRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Exceptions\Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = (new User())->query(); 
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        if(str_contains($arr[1], 'View')) {
            $arr[1] = str_replace('View', '', $arr[1]);
        }
        $arr = array_map('ucfirst', $arr);
        $title = implode(' \\ ', $arr);
        View::share('title', $title);
    }

    public function index()
	 {
        //  $search = $request->get('q');
		//  $users = $this->model->where('name', 'like', '%'.$search.'%')->orderBy('name', 'desc')->paginate();
        //  $users->appends(['q' => $search ]) ;
		//  return view('pages.user', [
        //      'users'=> $users,
        //      'search'=>$search
        //  ]);
         return view('pages.user');
	 }

     public function api(Request $request)
	 { 
        // Create new query to get data from table
        $test = $this->model->getQuery()->join('roles', 'users.roleid','=','roles.id')
        ->select(['users.*', 'roles.role']);
        // ->select(['users.id', 'users.name', 'users.username', 'users.password', 'users.email', 'users.roleid', 'roles.role']);
        $query = $this->model->setQuery($test);

        // $query = $this->model->with('role')->get(); // with ['relationship: name function relationship define in Model']
        // return object type
        // => can not search relationship column 
        return Datatables::of($query)
        ->addColumn('Action', function($object){
            $arr = [];
            $arr['edit'] = route('user.editView', $object);
            $arr['delete'] = route('user.delete', $object);
            return $arr;
        })->make(true);
	 }

     public function createView()
	 {
        $roles = Role::query()->where('role', '<>', 'root')->get();
        return view('pages.add_user', compact('roles'));
	 }

     public function create(CreateRequest $request)
	 {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->roleid = $request->get('roleid');
		$user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('user.index');
	 }

     public function editView($userId)
	 {
        $roles = Role::all();
        $object = $this->model->where('id', $userId)->first();
        return view('pages.edit_user', [
                'each' => $object,
                'roles' => $roles,
            ]
        );
	 }
     
     public function edit(UpdateRequest $request, $userId)
	 {
        // dd($userId);
        $object = $this->model->find($userId);
        $arr = $request->validated();
        if($arr['password'] != $object->getAttribute('password')) {
            $arr['password'] = Hash::make($request->password);
        }
        $object->fill($arr);
        $object->save();
        return redirect()->route('user.index');
	 }

     public function delete(DeleteRequest $request, $userId)
	 {
        // dd('ll');
        $arr = [];
        try {
            $object = $this->model->where('id', $userId)->first()->delete();
            $arr['status'] = true;
            $arr['message'] = 'Delete Successfully';
            return response($arr, 200);
        } catch (Exception $e) {
            $arr['status'] = false;
            $arr['message'] = 'Delete Failed';
        }
        return response($arr, 400);
	 }
}

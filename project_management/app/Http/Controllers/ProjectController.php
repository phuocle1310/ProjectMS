<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\CreateRequest;
use App\Http\Requests\Project\DeleteRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = (new Project())->query(); 
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
        if(!Auth::check()) {
            abort(403);
        }
         return view('pages.project');
    }

     public function api(Request $request)
	 { 
        if(!Auth::check()) {
            abort(403);
        }
        // Create new query to get data from table
        $user = Auth::user();
        if($user->role->role == 'root') {
            $test = $this->model->getQuery()->join('users', 'projects.userid','=','users.id')
            ->select(['projects.*', 'users.name']);
        }
        elseif($user->role->role == 'admin') {
            $test = $this->model->getQuery()->selectRaw("projects.*, users.name")
            ->fromRaw("projects inner join users on projects.userid = users.id")
            ->whereRaw("projects.userid = ".$user->id);
            
        }
        elseif($user->role->role == 'user') {
            $test = $this->model->getQuery()->selectRaw("projects.*, users.name")
            ->fromRaw("projects inner join users on projects.userid = users.id")
            ->whereRaw("projects.id in (select tasks.projectid from tasks where tasks.userid = ".$user->id.")");
            
        }
        // $test = $this->model->getQuery()->join('roles', 'users.roleid','=','roles.id')
        // ->select(['users.*', 'roles.role']);
        $query = $this->model->setQuery($test);
        
        // $query = $this->model->with('role')->get(); // with ['relationship: name function relationship define in Model']
        // return object type
        // => can not search relationship column 
        return DataTables::of($query)
        ->addColumn('Action', function($object){
            $arr = [];
            $arr['edit'] = route('project.editView', $object);
            $arr['delete'] = route('project.delete', $object);
            return $arr;
        })->make(true);
	 }

     public function createView(Request $request)
	 {
        if(!Auth::check() || Auth::user()->role->role == "user") {
            abort(403);
        }
        $users = User::query()->getQuery()->selectRaw("users.id, users.name")->join("roles", "users.roleid", "=", "roles.id")
                            ->where("roles.role", "=", "admin")->get();
        return view('pages.add_project', compact('users'));
	 }

     public function create(CreateRequest $request)
	 {
        if(!Auth::check()) {
            abort(403);
        }
        // dd($request);
        $project = new Project();
        $project->project = $request->project;
        $project->description = $request->get('description');
        $project->userid = $request->get('userid');
        $project->deadline = $request->get('deadline');
        $project->process = 0;
        $project->save();
        return redirect()->action([ProjectController::class, 'createView'])->with('success', 'Created Successfully');
	 }

     public function editView($projectId)
	 {
        if(!Auth::check()) {
            abort(403);
        }
        $object = $this->model->where('id', $projectId)->first();
        if($object == null)
            abort(404);
        return view('pages.edit_project', [
                'each' => $object,
            ]
        );
	 }
     
     public function edit(UpdateRequest $request, $projectId)
	 {
        if(!Auth::check() || Auth::user()->role->role == 'user') {
            abort(403);
        }
        $object = $this->model->find($projectId);
        $arr = $request->validated();
        $object->fill($arr);
        $object->save();
        return redirect()->route('project.index');
        
	 }

     public function delete(DeleteRequest $request, $projectId)
	 {
        if(Auth::check()) {
            $arr = [];
            try {
                $tasksOfProject = Task::query()->where('projectid', $projectId)->get();
                if(count($tasksOfProject) != 0) {
                    $arr['status'] = false;
                    $arr['message'] = 'Delete Failed';
                }
                else {
                    $object = $this->model->where('id', $projectId)->first()->delete();
                    $arr['status'] = true;
                    $arr['message'] = 'Delete Successfully';
                    return response($arr, 200);
                }
            } catch (Exception $e) {
                $arr['status'] = false;
                $arr['message'] = 'Delete Failed';
            }
            return response($arr, 400);
        }
        else {
            abort(403);
        }
	 }
}

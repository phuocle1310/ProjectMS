<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateRequest;
use App\Http\Requests\Task\DeleteRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = (new Task())->query(); 
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
         return view('pages.task');
    }

     public function api(Request $request)
	 { 
        if(!Auth::check()) {
            abort(403);
        }
        // Create new query to get data from table
        $user = Auth::user();
        if($user->role->role == 'root') {
            $test = $this->model->getQuery()->join('projects', 'tasks.projectid','=','projects.id')
                                            ->join('users', 'tasks.userid','=','users.id')
            ->select(['tasks.*', 'projects.project', 'users.name']);
        }
        elseif($user->role->role == 'admin') {
            $test = $this->model->getQuery()->selectRaw("tasks.*, projects.project, users.name")
            ->join('projects', 'tasks.projectid','=','projects.id')
            ->join('users', 'tasks.userid','=','users.id')
            ->whereRaw("projects.id in (SELECT projects.id FROM users 
                inner join projects on users.id = projects.userid 
                where projects.userid = ".$user->id.")");
        }
        else {
            $test = $this->model->getQuery()->join('projects', 'tasks.projectid','=','projects.id')
                                            ->join('users', 'tasks.userid','=','users.id')
                                            ->where('tasks.userid', $user->id)
                                            ->select(['tasks.*', 'projects.project', 'users.name']);
        }
        // $test = $this->model->getQuery()->join('roles', 'users.roleid','=','roles.id')
        // ->select(['users.*', 'roles.role']);
        $query = $this->model->setQuery($test);
        
        // $query = $this->model->with('role')->get(); // with ['relationship: name function relationship define in Model']
        // return object type
        // => can not search relationship column 
        return DataTables::of($query)
        ->addColumn('Action', function($object){
            // dd($object);
            $arr = [];
            $arr['edit'] = route('task.editView', $object);
            $arr['delete'] = route('task.delete', $object);
            $arr['update'] = route('task.update', $object);
            return $arr;
        })->make(true);
	 }

     public function createView(Request $request)
	 {
        if(!Auth::check() || Auth::user()->role->role == 'user') {
            abort(403);
        }
        $projects = Project::query()->where('deadline', '>=', Carbon::now())
                                    ->where('process', '<', 100)->get();
        // dd($projects);
        return view('pages.add_task', compact('projects'));
	 }

     public function apiGetUser($projectId) {
        if(!Auth::check() || Auth::user()->role->role == 'user') {
            abort(403);
        }
        $data = User::query()->getQuery()->selectRaw("users.id, users.name")
                    ->join('roles', 'users.roleid','=','roles.id')
                    ->whereRaw("roles.role = 'user' and users.id not in (select tasks.userid from tasks 
                                where tasks.projectid = ".$projectId.")")->get();
        // dd($data);
        return response($data, 200);
     }

     public function create(CreateRequest $request)
	 {
        if(!Auth::check() || Auth::user()->role->role == 'user') {
            abort(403);
        }
        try {
            $task = new Task();
            $task->projectid = $request->get('projectid');
            $task->userid = $request->get('userid');
            $task->mission = $request->get('mission');
            $task->description = $request->get('description');
            $task->save();
        } catch (Exception $e) {
            return redirect()->route("layout.base");
        }
        return redirect()->action([TaskController::class, 'createView'])->with('success', 'Created Successfully');
	 }

     public function update($taskId)
	 {
        if(!Auth::check()) {
            abort(403);
        }
        
        $arr = [];
        try {
            $object = $this->model->where('id', $taskId)->first();
            // dd($object->get());
            if($object == null)
                abort(404);
            else {
                $object->status = 0;
                $object->save();

                // update processing of project
                $project = Project::query()->find($object->projectid);
                $tasks_of_project = Task::query()->where('projectid', $object->projectid)->get();
                $total_tasks = count($tasks_of_project);
                $done_tasks_of_project = Task::query()->where('projectid', $object->projectid)
                                                    ->where('status', 0)->get();
                $total_done_tasks = count($done_tasks_of_project);
                $project->process = round($total_done_tasks/$total_tasks * 100, 2);
                $project->save();
            }
            $arr['status'] = true;
            $arr['message'] = 'Update status Successfully';
            return response($arr, 200);
        } catch (Exception $e) {
            $arr['status'] = false;
            $arr['message'] = 'Update status Failed';
        }
        return response($arr, 400);
	 
    }
     public function editView($taskId)
	 {
        if(!Auth::check() || Auth::user()->role->role == 'user') {
            abort(403);
        }
        $object = $this->model->where('id', $taskId)->first();
        if($object == null)
            abort(404);
        return view('pages.edit_task', [
                'each' => $object,
            ]
        );
	 }
     
     public function edit(UpdateRequest $request, $taskId)
	 {
        if(Auth::check() || Auth::user()->role->role != 'user')
        {
            $object = $this->model->find($taskId);
            $arr = $request->validated();
            $object->fill($arr);
            $object->save();
            return redirect()->route('task.index');
        }
        else {
            abort(403);
        }
	 }

     public function delete(DeleteRequest $request, $taskId)
	 {
        if(Auth::check()) {
            $arr = [];
            try {
                $object = $this->model->where('id', $taskId)->where('status', 1)->first();
                if($object == null) {
                    $arr['status'] = false;
                    $arr['message'] = 'Delete Failed';
                }
                else {
                    $object->delete();
                    $arr['status'] = true;
                    $arr['message'] = 'Delete Successfully';

                    // update project process
                    $project = Project::query()->find($object->projectid);
                    
                    $tasks_of_project = Task::query()->where('projectid', $object->projectid)->get();
                    $total_tasks = count($tasks_of_project);
                    $done_tasks_of_project = Task::query()->where('projectid', $object->projectid)
                                                        ->where('status', 0)->get();
                    $total_done_tasks = count($done_tasks_of_project);
                    $project->process = round($total_done_tasks/$total_tasks * 100, 2);
                    
                    $project->save();

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

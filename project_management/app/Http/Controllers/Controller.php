<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        if(!Auth::check()) {
            abort(403);
        }
        $total_projects = count(Project::all());
        $total_done_projects = count(Project::query()->where('process', 100)->get());
        $total_processing_projects = count(Project::query()->where('process', '<', 100)->get());
        $total_cancel_projects = count(Project::query()->where('process', '<', 50)->where('deadline', '<', Carbon::now())->get());
        $percent_done_projects = round((float)$total_done_projects/$total_projects, 5) * 100;
        $percent_processing_projects = round((float)$total_processing_projects/$total_projects, 5) * 100;
        $percent_cancel_projects = round((float)$total_cancel_projects/$total_projects, 5) * 100;
        $total_tasks = count(Task::all());
        $avg_tasks = round((float)$total_tasks/$total_projects, 5);
        

        return view('pages.index', compact('total_projects',
                        'total_done_projects',
                        'total_processing_projects',
                        'total_cancel_projects',
                        'total_tasks',
                        'percent_done_projects',
                        'percent_processing_projects',
                        'percent_cancel_projects',
                        'avg_tasks',
                    ));
    }
}

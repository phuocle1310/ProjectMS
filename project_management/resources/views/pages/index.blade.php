@extends('layout.base')
@section('content')

<div class="col-md-6 grid-margin transparent">
        <div class="row">
            <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                <p class="mb-4">Finished projects</p>
                <p class="fs-30 mb-2">{{ $total_done_projects }}/{{ $total_projects }}</p>
                <p>{{ $percent_done_projects }}%</p>
                </div>
            </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                <p class="mb-4">Processing projects</p>
                <p class="fs-30 mb-2">{{ $total_processing_projects }}/{{ $total_projects }}</p>
                <p>{{ $percent_processing_projects }}%</p>
                </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
            <div class="card card-light-blue">
                <div class="card-body">
                <p class="mb-4">Cancled projects</p>
                <p class="fs-30 mb-2">{{ $total_cancel_projects }}/{{ $total_projects }}</p>
                <p>{{ $percent_cancel_projects }}%</p>
                </div>
            </div>
            </div>
            <div class="col-md-6 stretch-card transparent">
            <div class="card card-light-danger">
                <div class="card-body">
                <p class="mb-4">Number of Tasks</p>
                <p class="fs-30 mb-2">{{ $total_tasks }}</p>
                <p>Avg task/project: {{ $avg_tasks }}</p>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
@stop
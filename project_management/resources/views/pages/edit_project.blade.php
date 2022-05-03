@extends('layout.base')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ $title }}</h4>
        </div>
    </div>
</div>
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{route('project.edit', $each)}}">
                @csrf
                @method('put')
                <p class="card-description">
                {{ $title }} Info
                </p>
                <input type="hidden" class="form-control" name="id" required="true;" value="{{ $each->id }}"/>
                <input type="hidden" class="form-control" name="userid" required="true;" value="{{ $each->userid }}"/>
                @if(session()->has('success'))
                    <div class="col-12">
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Project</label>
                            <div class="col-sm-9">
                            <input class="form-control" name="project" required="true;" value="{{ $each->project }}"/>
                                @if($errors->has('project'))
                                    <span class="text-danger">
                                        {{ $errors->first('project') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Admin</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" name="userid" disabled required="true;"  value="{{ $each->user->name }}"/>
                                @if($errors->has('userid'))
                                    <span class="text-danger">
                                        {{ $errors->first('userid') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="description" required="true;"  value="{{ $each->description }}"/>
                                @if($errors->has('description'))
                                    <span class="text-danger">
                                        {{ $errors->first('description') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Deadline</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="deadline" required="true;"  value="{{ $each->deadline }}"/>
                                @if($errors->has('deadline'))
                                    <span class="text-danger">
                                        {{ $errors->first('deadline') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-outline-primary" id="create">
                            <div class="row">
                                <div class="col-sm-1"><i class="mdi mdi-account-plus"></i></div>
                                <div class="col-sm-9"><strong> Save Changes</strong></div>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
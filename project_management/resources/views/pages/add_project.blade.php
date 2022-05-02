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
            <form method="post" action="{{route('project.create')}}">
                @csrf
                <p class="card-description">
                {{ $title }} Info
                </p>
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
                            <input class="form-control" name="project" required="true;" value="{{ old('project') }}"/>
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
                                <select class="form-control" name="userid">
                                <option selected value="0">Choose admin</option>
                                    @foreach($users as $each)
                                        @if (old('userid') == $each->id)
                                            <option value="{{ $each->id }}" selected>{{ $each->name}}</option>
                                        @else
                                            <option value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
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
                                <input type="text" class="form-control" name="description" required="true;"  value="{{ old('description') }}"/>
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
                                <input type="date" class="form-control" name="deadline" required="true;"  value="{{ old('deadline') }}"/>
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
                                <div class="col-sm-9"><strong> Create Project</strong></div>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
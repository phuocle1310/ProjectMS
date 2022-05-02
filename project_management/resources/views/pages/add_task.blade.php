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
            <!-- <h4 class="card-title">{{ $title }}</h4> -->
            <form method="post" action="{{route('task.create')}}">
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
                                <select class="form-control" name="projectid" id="project-select" onclick="getStaff(this)">
                                <option selected value="0">Choose project</option>
                                    @foreach($projects as $each)
                                        @if (old('projectid') == $each->id)
                                            <option value="{{ $each->id }}" selected>{{ $each->project}}</option>
                                        @else
                                            <option value="{{ $each->id }}">{{ $each->project }}</option>
                                        @endif
                                    @endforeach
                                   
                                </select>
                                @if($errors->has('projectid'))
                                    <span class="text-danger">
                                        {{ $errors->first('projectid') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Staff</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="userid" id="user-select">
                                
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
                            <label class="col-sm-3 col-form-label">Mission</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="mission" required="true;"  value="{{ old('mission') }}"/>
                                @if($errors->has('mission'))
                                    <span class="text-danger">
                                        {{ $errors->first('mission') }}
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
@push('js')
<script>
        getStaff = function(object) {
            var url = "{{ route('task.api.getUser', "+id+") }}";
            url = url.replace("+id+", object.value);

            var userSelect = $("#user-select").html("");
            if(object.value != 0) {
                $.ajax({
                    type: "get",
                    url: url,
                    success: function (data, status) {
                        userSelect.append("<option value=\"0\" selected>Choose staff</option>");
                        $(data).each(function(i) {
                            userSelect.append("<option value=\""+data[i].id+"\">"+data[i].name+"</option>");
                        });
                    },
                    error: function (data, status) {
                        alert("Can not get staff");
                    },
                });
            }
        }
        
</script>
@endpush
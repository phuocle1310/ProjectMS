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
            <form method="post" action="{{route('user.create')}}">
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
                            <label class="col-sm-3 col-form-label">Staff Name</label>
                            <div class="col-sm-9">
                            <input class="form-control" name="name" required="true;" value="{{ old('name') }}"/>
                                @if($errors->has('name'))
                                    <span class="text-danger">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                                <!-- <select class="form-control" path="doctor" id="doctor" onchange="isNull()">
                                    <option value="">Choose the doctor</option>
                                    <c:forEach items="${doctors}" var="doctor">
                                        <c:if test="${doctor.account.id == null}">
                                            <option value="${doctor.id}">${doctor.name}</option>
                                        </c:if>
                                    </c:forEach>
                                </select> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="roleid">
                                    @foreach($roles as $each)
                                        @if (old('roleid') == $each->id)
                                            <option value="{{ $each->id }}" selected>{{ $each->role}}</option>
                                        @else
                                            <option value="{{ $each->id }}">{{ $each->role }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" required="true;"  value="{{ old('email') }}"/>
                                @if($errors->has('email'))
                                    <span class="text-danger">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="username" required="true;"  value="{{ old('username') }}"/>
                                @if($errors->has('username'))
                                    <span class="text-danger">
                                        {{ $errors->first('username') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" required="true;"  value="{{ old('password') }}"/>
                                @if($errors->has('password'))
                                    <span class="text-danger">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="confirmPassword" required="true;"  value="{{ old('confirmPassword') }}"/>
                                @if($errors->has('confirmPassword'))
                                    <span class="text-danger">
                                        {{ $errors->first('confirmPassword') }}
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
                                <div class="col-sm-9"><strong> Create User</strong></div>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
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
            <form method="post" action="{{ route('user.edit', $each) }}">
                @csrf
                @method('put')
                <p class="card-description">
                {{ $title }} Info 
                </p>
                <input type="hidden" class="form-control" name="id" required="true;" value="{{ $each->id }}"/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Staff Name</label>
                            <div class="col-sm-9">
                            <input class="form-control" name="name" required="true;" value="{{ $each->name }}"/>
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
                                <select class="form-control" name="roleid" disabled>
                                    @foreach($roles as $role)
                                        @if($role->id === $each->role->id)
                                            <option selected value="{{ $each->role->id }}">{{ $each->role->role }}</option>
                                        @else
                                            <option value="{{ $role->id }}">{{ $role->role }}</option>
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
                                <input type="email" class="form-control" name="email" required="true;"  value="{{ $each->email }}"/>
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
                                <input class="form-control" name="username" required="true;"  value="{{ $each->username }}" disabled/>
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
                                <input type="password" class="form-control" name="password" required="true;"  value="{{ $each->password }}"/>
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
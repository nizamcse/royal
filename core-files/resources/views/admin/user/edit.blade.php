@extends('layouts.app')

@section('content')
    <form action="{{ route('update-user',['company_id' => Request::segment(2),'id' => $user->id]) }}" method="post">
        @csrf
        <div class="box">
            <div class="box-header">
                <h4>
                    CREATE USER
                    <a href="{{ route('users',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                        <i class="fa fa-plus-circle"></i> USERS
                    </a>
                </h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ? old('name') : $user ? $user->name : ''}}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') ? old('email') : $user ? $user->email : ''}}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Role</label>
                            <select name="role_id" id="" class="form-control">
                                <option value="">-- Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') ? 'selected="selected"' : $user ? $user->roles->contains($role->id) ? 'selected="selected"' : '' : ''}}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                </div>
                <div class="form-group text-right" style="margin-top: 30px">
                    <button class="btn btn-sm flat btn-info" type="submit">UPDATE USER</button>
                </div>
            </div>
        </div>
    </form>

@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

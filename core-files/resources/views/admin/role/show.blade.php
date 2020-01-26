@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                LIST OF PERMISSION FOR ROLE - <strong class="text-success-active">{{ $role->name }}</strong>
                @can('roles-show')
                    <a href="{{ route('roles',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                        <i class="fa fa-plus-circle"></i> ROLES
                    </a>
                @endcan
            </h4>
        </div>
        <div class="box-body">
            <div class="row">
                @foreach($role->permissions as $permission)
                    <div class="col-md-3">
                        <p><i class="fa fa-check-circle"></i>&nbsp;{{ $permission->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

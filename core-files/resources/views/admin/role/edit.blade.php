@extends('layouts.app')

@section('content')
    <form action="{{ route('update-role',['company_id' => Request::segment(2),'id' => $role->id]) }}" method="post">
        @csrf
        <div class="box">
            <div class="box-header">
                <h4>
                    UPDATE ROLE
                    <a href="{{ route('roles',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                        <i class="fa fa-plus-circle"></i> ROLES
                    </a>
                </h4>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Role Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $role->name }}" required>
                </div>
            </div>
        </div>

        <create-role :items="{permissions: {{ $permissions }},selectedPermissions: {{ $selected_permissions }} }"></create-role>
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

@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                COMPANY PERMISSIONS LIST
            </h4>
            <hr>
        </div>
        <div class="box-body">
            <div class="row">
                @foreach($permissions as $permission)
                    <div class="col-md-3">
                        <p><i class="fa fa-check-circle text-success"></i>&nbsp;{{ $permission->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection

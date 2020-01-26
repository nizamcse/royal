@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                ALL ABOUT EMPLOYEE ATTENDANCE
                <a href="{{ route('create-attendance',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-info pull-right flat"><i class="fa fa-plus-square-o"></i> Create Attendance</a>
                <a href="{{ route('create-attendance',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-success pull-right flat"><i class="fa fa-cloud-upload"></i> Upload Excel</a>
            </h4>
        </div>
    </div>
    <attendance-report :items="{apiUrl: '{{ route('get-attendance-report',['company_id' => Request::segment(2)]) }}'}"></attendance-report>
@endsection


@section('styles')
@endsection


@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

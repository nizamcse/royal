@extends('layouts.app')

@section('content')
    <employee-salaries
            :items="{
            apiUrl: '{{ route('get-employee-salaries',['company_id' => Request::segment(2)]) }}',
            employees: {{ $employees }},
            view: {url: '{{ route('employee-salary',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('employee-salary-show',Request::segment(2)) ? 1 : 0 }} },
            download: {url: '{{ route('download-employee-salaries',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('employee-salaries-show',Request::segment(2)) ? 1 : 0 }} },
            deleteSalary: {url: '{{ route('employee-salary-delete',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('employee-salary-delete',Request::segment(2)) ? 1 : 0 }}} }">
    </employee-salaries>
@endsection

@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

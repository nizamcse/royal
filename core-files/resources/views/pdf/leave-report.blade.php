@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h4 class="text-center text-uppercase">LEAVE REPORT</h4>
        <table class="table border-none mb-30">
            <tbody>
            <tr>
                <td><strong>EMPLOYEE</strong>: {{  $employee ? $employee->name : 'ALL'  }}</td>
                <td>MONTH: {{ $month ? \Carbon\Carbon::createFromDate($year,$month)->format('F') : 'ALL' }}</td>
                <td>YEAR: {{$year }}</td>
            </tr>
            </tbody>
        </table>
        <p class="text-center"></p>
        <hr>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SL</th>
                <th>Employee Name</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Allowed Days</th>
            </tr>
            </thead>
            <tbody>
            @foreach($leaves as $k => $leave)
            <tr>
                <td>{{ $k+1 }}</td>
                <td>{{ $leave->employee->name }}</td>
                <td>{{ $leave->from_date }}</td>
                <td>{{ $leave->to_date }}</td>
                <td>{{ $leave->allowed_days }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('style')
    <style>
        table > thead > tr > th,
        table > tbody > tr > td{
            font-size: 8px;
            font-weight: normal;
        }
    </style>
@endsection
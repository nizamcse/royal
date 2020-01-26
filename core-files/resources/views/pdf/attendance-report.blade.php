@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h4 class="text-center text-uppercase">ATTENDANCE REPORT</h4>
        <table class="table border-none mb-30">
            <tbody>
            <tr>
                <td><strong>EMPLOYEE</strong>: {{  $employee ? $employee->name : 'ALL'  }}</td>
                <td>FROM: {{ \Carbon\Carbon::parse($from_date)->format('jS F Y') }}</td>
                <td>TO: {{ \Carbon\Carbon::parse($to_date)->format('jS F Y') }}</td>
            </tr>
            </tbody>
        </table>
        <p class="text-center"></p>
        <hr>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>DATE</th>
                <th>ID</th>
                <th>EMPLOYEE</th>
                <th>IN</th>
                <th>EXIT</th>
                <th>TOTAL</th>
                <th>OT</th>
                <th>Total Wage</th>
                <th>OT Wage</th>
                <th>Net Wage</th>
            </tr>
            </thead>
            <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->attendance_date }}</td>
                    <td>{{ $attendance->employee->id }}</td>
                    <td>{{ $attendance->employee->name }}</td>
                    <td>{{ $attendance->in_time }}</td>
                    <td>{{ $attendance->exit_time }}</td>
                    <td>{{ $attendance->measurement_quantity }}</td>
                    <td>{{ $attendance->overtime }}</td>
                    <td>{{ $attendance->total_wage }}</td>
                    <td>{{ $attendance->overtime_wage }}</td>
                    <td>{{ $attendance->net_wage }}</td>
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
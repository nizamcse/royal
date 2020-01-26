@extends('layouts.pad')

@section('content')
    <div class="box-body">
        <h5 class="text-center w-100">SALARY SHEET FOR THE MONTH OF {{ strtoupper(Config::get('enums.month')[$month]) ?? 'ALL' }},{{ $year }}</h5>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th rowspan="2">SL</th>
            <th rowspan="2">Employee</th>
            <th colspan="4">Attendance</th>
            <th colspan="5">Salary</th>
            <th rowspan="2">Gross Salary</th>
            <th colspan="3">Overtime</th>
            <th rowspan="2">Allowance</th>
            <th rowspan="2">Deduction</th>
            <th rowspan="2">Net Amount</th>
            <th rowspan="2">Signature</th>
        </tr>
        <tr>
            <th class="vertical-text"><span>Attend</span></th>
            <th class="vertical-text"><span>Absence</span></th>
            <th class="vertical-text"><span>Leave</span></th>
            <th class="vertical-text"><span>Pay Day</span></th>
            <th class="vertical-text"><span>Basic</span></th>
            <th class="vertical-text"><span>House Rent</span></th>
            <th class="vertical-text"><span>Convey</span></th>
            <th class="vertical-text"><span>Food</span></th>
            <th class="vertical-text"><span>Medical</span></th>
            <th class="vertical-text"><span>OT Hour</span></th>
            <th class="vertical-text"><span>Rate</span></th>
            <th class="vertical-text"><span>Amount</span></th>
        </tr>
        </thead>
    </table>
@endsection

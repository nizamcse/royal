@extends('layouts.download')

@section('content')
    <div class="box">
        <br>
        <br>
        <br>
        <br>
        <h3><strong>LOG PURCHASE ORDER </strong>(Purchase Date : <strong>{{ \Carbon\Carbon::parse($log_purchase_order->purchase_date)->toFormattedDateString() }}</strong>)</h3>
        <h4>VENDOR DETAILS</h4>
        <table class="table table-bordered">
            <tr>
                <td><strong>Vendor Name: </strong>{{ $log_purchase_order->vendor->name }} </td>
                <td><strong>Address: </strong>{{ $log_purchase_order->vendor->address }} </td>
                <td><strong>Contact No.: </strong>{{ $log_purchase_order->vendor->contact_no }} </td>
            </tr>
        </table>
        <h4>LOG PURCHASE ORDER DETAILS</h4>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td><strong>PO No (By System) : </strong>{{ $log_purchase_order->id }}</td>
                <td><strong>Chalan No (Manual Entry) : </strong>{{ $log_purchase_order->challan_no_mannual }}</td>
                <td><strong>Additional Chalan No: </strong>{{ $log_purchase_order->additional_challan_no_mannua }}</td>
            </tr>
            <tr>
                <td><strong>Total Amount : </strong> {{ number_format($log_purchase_order->amount, 2) }} BDT</td>
                <td><strong>Paid Amount : </strong> {{ number_format($log_purchase_order->paid_amount, 2) }} BDT</td>
                <td><strong>Due Amount : </strong> {{ number_format($log_purchase_order->due_amount, 2) }} BDT</td>
            </tr>
            </tbody>
        </table>
        <h5>PURCHASE LOG SUMMARY</h5>
        <table class="table table-bordered list-table">
            <thead>
            <tr>
                <th>Category</th>
                <th>Grade</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($log_data as $data)
                @php
                    $grade_index = 1;
                @endphp
                @foreach($data['data'] as $grade => $logs)
                    <tr>
                        @if($grade_index == 1)
                            <td rowspan="{{ count($data['data'],COUNT_RECURSIVE) }}">{{ $data['category']->name  ?? '' }}</td>
                        @endif
                        <td>{{ $grade }}</td>
                        <td>{{ $logs->sum('quantity') }}</td>
                        <td> {{ number_format($logs->sum('total_price'),2) }} BDT</td>
                    </tr>
                    @php
                        $grade_index++;
                    @endphp
                @endforeach
            @endforeach
            </tbody>
        </table>
        <h5>PURCHASE LOG DETAILS</h5>
        <table class="table table-bordered list-table">
            <thead>
            <tr>
                <th>SL#</th>
                <th>Category</th>
                <th>Grade</th>
                <th>SL NO#</th>
                <th>Radius</th>
                <th>Height</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @php
                $row = 1;
            @endphp
            @foreach($log_data as $data)
                @php
                    $grade_index = 1;
                @endphp
                @foreach($data['data'] as $grade => $logs)
                    @php
                        $log_index = 1;
                    @endphp
                    @foreach($logs as $k => $log)
                        <tr>
                            <td>{{ $row++ }}</td>
                            <td>{{ $data['category']->name  ?? '' }}</td>
                            <td>{{ $grade }}</td>
                            <td>{{ $log->log_no }}</td>
                            <td>{{ $log->radius }}</td>
                            <td>{{ $log->height }}</td>
                            <td>{{ $log->quantity }}</td>
                            <td>{{ number_format($log->total_price,2) }}</td>
                        </tr>
                        @php
                            $log_index++;
                        @endphp
                    @endforeach
                    @php
                        $grade_index++;
                    @endphp
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
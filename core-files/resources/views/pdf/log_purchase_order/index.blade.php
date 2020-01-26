@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h4>LOG PURCHASE ORDERS</h4>
        <table id="po-table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>PO NO</th>
                <th>CH NO</th>
                <th>Vendor</th>
                <th>Amount</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($log_purchase_orders as $k => $log_purchase_order)
                <tr>
                    <td>{{ $log_purchase_order->id }}</td>
                    <td>{{ $log_purchase_order->challan_no_mannual }}</td>
                    <td>{{ $log_purchase_order->vendorName() }}</td>
                    <td>{{ $log_purchase_order->amount }}</td>
                    <td>{{ $log_purchase_order->paid_amount }}</td>
                    <td>{{ $log_purchase_order->due_amount }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

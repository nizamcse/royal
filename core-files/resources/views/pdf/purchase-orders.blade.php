@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h4>PURCHASE ORDERS</h4>
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
            @foreach($purchase_orders as $k => $purchase_order)
                <tr>
                    <td>{{ $purchase_order->id }}</td>
                    <td>{{ $purchase_order->challan_no_mannual }}</td>
                    <td>{{ $purchase_order->vendorName() }}</td>
                    <td>{{ $purchase_order->amount }}</td>
                    <td>{{ $purchase_order->paid_amount }}</td>
                    <td>{{ $purchase_order->due_amount }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

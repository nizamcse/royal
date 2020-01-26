@extends('layouts.download')
@section('content')
    <div class="box-body">
        <h4>SALES ORDERS</h4>
        <table id="sales-orders" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SL</th>
                <th>#ORDER ID</th>
                <th>DATE</th>
                <th>CUSTOMER NAME</th>
                <th>CONTACT NO</th>
                <th>AMOUNT</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales_orders as $k => $sales_order)
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $sales_order->id }}</td>
                    <td>{{ $sales_order->sold_out_date }}</td>
                    <td>{{ $sales_order->customer ? $sales_order->customer->name : $sales_order->name }}</td>
                    <td>{{ $sales_order->customer ? $sales_order->customer->contact_no :$sales_order->contact_no  }}</td>
                    <td>{{ $sales_order->total_amount  }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

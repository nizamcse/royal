@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                CUSTOMER DETAILS
            </h3>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h4>SALES ORDER DETAILS</h4>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Delivered Qty</th>
                    <th>Returned Qty</th>
                    <th>Received Qty</th>
                    <th>Remaining Qty</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sales_order->details as $detail)
                    <tr>
                        <td>{{ $detail->good ? $detail->good->name : '' }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ $detail->delivered_quantity }}</td>
                        <td>{{ $detail->returned_quantity }}</td>
                        <td>{{ $detail->received_quantity }}</td>
                        <td>{{ $detail->remaining_quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('script')


@endsection

@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h4>SALES ORDER CHALAN DETAILS</h4>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>Customer Name: {{ $chalan->salesOrder ? $chalan->salesOrder->name : '' }}</td>
                <td>Contact No: {{ $chalan->salesOrder ? $chalan->salesOrder->contact_no : '' }}</td>
                <td>Address: {{ $chalan->salesOrder ? $chalan->salesOrder->address : '' }}</td>
                <td>Chalan No Auto:  {{ $chalan->chalan_no }}</td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SL#</th>
                <th>Name</th>
                <th style="width: 100px">Qty</th>
                <th style="width: 100px">Unit</th>
                <th style="width: 100px">Unit Price</th>
                <th style="width: 100px">Amount</th>
                <th style="width: 100px">Discount(%)</th>
                <th style="width: 100px">Sub Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $k => $item)
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>{{ $item['unit'] }}</td>
                    <td>{{ $item['unit_price'] }}</td>
                    <td>{{ $item['sub_total'] }}</td>
                    <td>{{ $item['discount'] }}</td>
                    <td>{{ $item['final_sub_total'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7">Grand Total</td>
                <td>{{ $grand_total }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
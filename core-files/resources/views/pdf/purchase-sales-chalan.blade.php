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
                <th>Name</th>
                <th style="width: 100px">Qty</th>
            </tr>
            </thead>
            <tbody>
            @foreach($chalan->itemDetails as $detail)
                <tr>
                    <td>{{ $detail->inventoryItem ? $detail->inventoryItem->name : '' }}</td>
                    <td>{{ $detail->received_qty }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
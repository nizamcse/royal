@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                CUSTOMER DETAILS
            </h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>Customer Name: {{ $chalan->salesOrder ? $chalan->salesOrder->name : '' }}</td>
                    <td>Contact No: {{ $chalan->salesOrder ? $chalan->salesOrder->contact_no : '' }}</td>
                    <td>Address: {{ $chalan->salesOrder ? $chalan->salesOrder->address : '' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h4>SALES ORDER CHALAN DETAILS</h4>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th style="width: 100px">Qty</th>
                </tr>
                </thead>
                <tbody>
                @foreach($chalan->details as $detail)
                    <tr>
                        <td>{{ $detail->good ? $detail->good->name : '' }}</td>
                        <td>{{ $detail->received_qty }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('script')


@endsection

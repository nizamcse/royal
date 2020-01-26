@extends('layouts.download')
@section('content')
    <div class="box-body">
        <h4 class="text-center">SALES ORDER REPORT</h4>
        <p><strong>Customer: </strong> {{ $customer != null ? $customer : "All Customers" }}</p>
        <p><strong>Product: </strong> {{ $good != null ? $good : "All Products" }}</p>

        <table class="table table-borderless">
            <tr>
                <td><strong>Date From: </strong>{{ $date_from != null ? $date_from : "" }}</td>
                <td><strong>Date To: </strong> {{ $date_to != null ? $date_to : "" }}</td>
                <td><strong>Report Generated at: </strong>{{ $report_generated_date }}</td>
            </tr>
        </table>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>SL#</th>
                    <th>Product Name</th>
                    <th class="text-center">Quantities</th>
                    <th class="text-center">Unit Name</th>
                    <th class="text-center">Unit Price</th>
                    <th class="text-right">Total Price</th>
                </tr>
            </thead>
            @foreach($sales_order_report as $k => $item)
            <tr>
                <td>{{ $k+1 }}</td>
                <td @if( $item->good->deleted_at != null ) style="color: red"  @endif>{{ $item->good ? $item->good->detail_name : "null" }} {{ $item->good->deleted_at != null ? "[Deleted]" : "" }}</td>
                <td class="text-center">{{ $item->quantities ? $item->quantities : 0}}</td>
                <td class="text-center">{{ $item->good ? $item->good->unit->name : "null"}}</td>
                <td class="text-center">{{ $item->good ? $item->good->price : 0}}</td>
                <td class="text-right">{{ $item->sold_total ? number_format($item->sold_total, 2) : 0}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-right text-capitalize"><strong>Total: </strong></td>
                <td class="text-right"><strong>{{ number_format($total, 2) }}</strong></td>
            </tr>
        </table>

        <br>
        <br>
        <br>
        <br>
        <p>----------------------------------</p>
        <p>Authorized Signature</p>

    </div>
@endsection
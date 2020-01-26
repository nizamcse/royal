@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h2><strong>SALES ORDER </strong>(<small>Sold Out Date : <strong>{{ \Carbon\Carbon::parse($sales_order->sold_out_date)->toFormattedDateString() }}</strong></small>)</h2>
        <div>
            <h4>CUSTOMER DETAILS</h4>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Customer Name: </strong>{{ $sales_order->customer ? $sales_order->customer->name : $sales_order->name }} </td>
                    <td><strong>Address: </strong>{{ $sales_order->customer ? $sales_order->customer->address : $sales_order->address }} </td>
                    <td><strong>Customer Name: </strong>{{ $sales_order->customer ? $sales_order->customer->contact_no : $sales_order->contact_no }} </td>
                </tr>
            </table>
        </div>
        <div>
            <h4>SALES ORDER DETAILS</h4>
            <h5><strong>Type: </strong>{{ $sales_order->type == 1 ? "Purchase Sales Order" : "Sales Order" }}</h5>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td><strong>PSO NO (By System): </strong>{{ $sales_order->id }}</td>
                    <td><strong>PSO NO (Manual Entry): </strong>{{ $sales_order->so_no_manual }}</td>
                    <td><strong>Additional PSO NO (Extra Manual): </strong>{{ $sales_order->additional_so_no_manual }}</td>
                </tr>
                <tr>
                    <td><strong>Total Product Price: </strong> {{ $sales_order->total_amount ?? 0 }} BDT</td>
                    <td><strong>Total Return Product Amount: </strong> {{ $sales_order->return_product_amount ?? 0 }} BDT</td>
                    <td><strong>Total Discount Price: </strong> {{ $sales_order->total_discount ?? 0 }} BDT</td>
                </tr>
                <tr>
                    <td @if(!count($sales_order->salesOrderOtherChargeDetails)) colspan="3" @endif><strong>Total Other Charge: </strong> {{ $sales_order->other_charge ?? 0 }} BDT</td>
                    @if(count($sales_order->salesOrderOtherChargeDetails) > 0)
                        <td colspan="2">
                            <strong>OTHER CHARGE DETAILS</strong>
                            <ul>
                                @foreach($sales_order->salesOrderOtherChargeDetails as $other_charge_detail)
                                    <li><strong>{{ $other_charge_detail->charge_description }}: </strong> {{ $other_charge_detail->charge_amount }} BDT</li>
                                @endforeach
                            </ul>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td><strong>Total Payable Amount : </strong> {{ $sales_order->payable_amount }} BDT</td>
                    <td><strong>Total Paid Amount : </strong> {{ $sales_order->paid_amount }} BDT</td>
                    <td><strong>Total Due Amount : </strong> {{ $sales_order->due_amount }} BDT</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h4>SALES PRODUCT DETAILS</h4>
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
                @foreach($sales_order->purchaseSalesDetails as $detail)
                    <tr>
                        <td>{{ $detail->inventoryItem ? $detail->inventoryItem->materialName() ?? '' : '' }}</td>
                        <td class="text-right">{{ $detail->quantity }}</td>
                        <td class="text-right">{{ $detail->delivered_quantity }}</td>
                        <td class="text-right">{{ $detail->returned_quantity }}</td>
                        <td class="text-right">{{ $detail->received_quantity }}</td>
                        <td class="text-right">{{ $detail->remaining_quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
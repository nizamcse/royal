@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h4>PURCHASE ORDER DETAILS</h4>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td><strong>PO No (By System) : </strong>{{ $purchase_order->id }}</td>
                <td><strong>Chalan No (Mannual Entry) : </strong>{{ $purchase_order->challan_no_mannual }}</td>
                <td><strong>Additional Chalan No: </strong>{{ $purchase_order->additional_challan_no_mannua }}</td>
            </tr>
            <tr>
                <td><strong>Date : </strong>{{ $purchase_order->purchase_date }}</td>
                <td><strong>Vendor : </strong>{{ $purchase_order->vendor->name }}</td>
                <td></td>
            </tr>
            <tr>
                <td><strong>Total Amount : </strong>{{ $purchase_order->amount }}</td>
                <td><strong>Paid Amount : </strong>{{ $purchase_order->paid_amount }}</td>
                <td><strong>Due Amount : </strong>{{ $purchase_order->due_amount }}</td>
            </tr>
            </tbody>
        </table>
        @if(count($purchase_order->rawMaterials))
            <table class="table table-bordered list-table">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th class="w-100">Unit Price</th>
                    <th class="w-100">Quantity</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchase_order->rawMaterials as $material)
                    <tr>
                        <td>{{ $material->materialName() }}</td>
                        <td>{{ $material->unit ? $material->unit->name : '' }}</td>
                        <td class="w-100">{{ $material->price_per_unit }}</td>
                        <td class="w-100">{{ $material->quantity }}</td>
                        <td class="w-100 text-right">{{ number_format($material->amount,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(count($purchase_order->otherMaterials))
            <table class="table table-bordered list-table">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Thickness</th>
                    <th>Size</th>
                    <th>Unit</th>
                    <th class="w-100">Unit Price</th>
                    <th class="w-100">Quantity</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchase_order->otherMaterials as $material)
                    <tr>
                        <td>{{ $material->materialName() }}</td>
                        <td>{{ $material->thickness }}</td>
                        <td>{{ $material->size }}</td>
                        <td>{{ $material->unit ? $material->unit->name : '' }}</td>
                        <td class="w-100">{{ $material->price_per_unit }}</td>
                        <td class="w-100">{{ $material->quantity }}</td>
                        <td class="w-100 text-right">{{ number_format($material->amount,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(count($purchase_order->logs))
            <table class="table table-bordered list-table">
                <thead>
                <tr>
                    <th>NO#</th>
                    <th>Radius</th>
                    <th>Height</th>
                    <th>Grade</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchase_order->logs as $log)
                    <tr>
                        <td>{{ $log->log_no }}</td>
                        <td>{{ $log->radius }}</td>
                        <td>{{ $log->height }}</td>
                        <td>{{ $log->grade }}</td>
                        <td>{{ $log->quantity }}</td>
                        <td class="text-right">{{ number_format($log->total_price,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
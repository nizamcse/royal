@extends('layouts.download')

@section('content')
    <div class="box">
        <br>
        <br>
        <br>
        <br>
        <h3><strong>MATERIAL PURCHASE ORDER </strong>(Purchase Date : <strong>{{ \Carbon\Carbon::parse($material_purchase_order->purchase_date)->toFormattedDateString() }}</strong>)</h3>
        <h4>VENDOR DETAILS</h4>
        <table class="table table-bordered">
            <tr>
                <td><strong>Vendor Name: </strong>{{ $material_purchase_order->vendor->name }} </td>
                <td><strong>Address: </strong>{{ $material_purchase_order->vendor->address }} </td>
                <td><strong>Contact No.: </strong>{{ $material_purchase_order->vendor->contact_no }} </td>
            </tr>
        </table>
        <h4>MATERIAL PURCHASE ORDER DETAILS</h4>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td><strong>PO No (By System) : </strong>{{ $material_purchase_order->id }}</td>
                <td><strong>Chalan No (Manual Entry) : </strong>{{ $material_purchase_order->challan_no_mannual }}</td>
                <td><strong>Additional Chalan No: </strong>{{ $material_purchase_order->additional_challan_no_mannua }}</td>
            </tr>
            <tr>
                <td><strong>Total Amount : </strong> {{ number_format($material_purchase_order->amount, 2) }} BDT</td>
                <td><strong>Paid Amount : </strong> {{ number_format($material_purchase_order->paid_amount, 2) }} BDT</td>
                <td><strong>Due Amount : </strong> {{ number_format($material_purchase_order->due_amount, 2) }} BDT</td>
            </tr>
            </tbody>
        </table>
        @if(count($material_purchase_order->rawMaterials))
            <h5 class="box-title">RAW MATERIAL DETAILS</h5>
            <table class="table table-bordered list-table">
                        <thead>
                        <tr>
                            <th>SL#</th>
                            <th>Item Name</th>
                            <th>Unit</th>
                            <th class="w-100">Unit Price</th>
                            <th class="w-100">Quantity</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($material_purchase_order->rawMaterials as $k => $material)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $material->materialName() }}</td>
                                <td>{{ $material->unit ? $material->unit->name : '' }}</td>
                                <td class="w-100">{{ $material->price_per_unit }}</td>
                                <td class="w-100">{{ $material->quantity }}</td>
                                <td class="w-100 text-right">{{ number_format($material->amount,2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

            </div>
        @endif
        @if(count($material_purchase_order->otherMaterials))
            <h5 class="box-title">OTHER MATERIAL DETAILS</h5>
            <table class="table table-bordered list-table">
            <thead>
            <tr>
                <th>SL#</th>
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
            @foreach($material_purchase_order->otherMaterials as $k => $material)
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $material->materialName() }}</td>
                    <td>{{ $material->rawMaterial->thickness ??  '' }}</td>
                    <td>{{ $material->rawMaterial->size ?? '' }}</td>
                    <td>{{ $material->unit ? $material->unit->name : '' }}</td>
                    <td class="w-100">{{ $material->price_per_unit }}</td>
                    <td class="w-100">{{ $material->quantity }}</td>
                    <td class="w-100 text-right">{{ number_format($material->amount,2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="text-success">PURCHASE PAYMENTS<a href="{{ route('create-purchase-payment',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-info flat pull-right"><i class="fa fa-plus-circle"></i> CREATE PURCHASE PAYMENT</a></h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped" id="purchasePaymentsTable">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>PO ID (By System)</th>
                    <th>CHALAN NO (Manual Entry)</th>
                    <th>DATE</th>
                    <th>METHOD</th>
                    <th>OTHER INFORMATION</th>
                    <th>AMOUNT</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchase_payments as $k => $purchase_payment)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td><a href="{{ route('purchase-order',['company_id' => Request::segment(2),'id' => $purchase_payment->purchase_order_id]) }}">{{ $purchase_payment->purchase_order_id }}</a></td>
                        <td>{{ $purchase_payment->purchaseOrder->challan_no_mannual ?? '' }}</td>
                        <td>{{Carbon\Carbon::parse( $purchase_payment->payment_date)->format('d F Y') }}</td>
                        <td>{{ $purchase_payment->paymentType ? $purchase_payment->paymentType->name : '' }}</td>
                        <td>
                            @foreach($purchase_payment->fields as $field)
                                <strong>{{ $field->name }} : </strong>{{ $field->pivot ? $field->pivot->field_value : '' }},
                            @endforeach
                        </td>
                        <td>{{ $purchase_payment->amount }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#purchasePaymentsTable").dataTable({
                "order": [
                    [ 1, 'desc' ]
                ]
            });
        });

    </script>

@endsection

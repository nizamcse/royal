@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="text-success">SALES PAYMENTS<a href="{{ route('create-sales-payment',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-info flat pull-right"><i class="fa fa-plus-circle"></i> CREATE SALES PAYMENT</a></h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped" id="salesPaymentsTable">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>SO NO (By System)</th>
                    <th>SO NO (Manual Entry)</th>
                    <th>DATE</th>
                    <th>METHOD</th>
                    <th>OTHER INFORMATION</th>
                    <th>AMOUNT</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sales_payments as $k => $sales_payment)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td><a href="{{ route('salesPayments.show',['company_id' => Request::segment(2),'id' => $sales_payment->id]) }}">{{ $sales_payment->id }}</a></td>
                        <td><a href="{{ route('salesPayments.show',['company_id' => Request::segment(2),'id' => $sales_payment->id]) }}">{{ $sales_payment->so_no_manual }}</a></td>
                        <td>{{Carbon\Carbon::parse( $sales_payment->payment_date)->format('d F Y') }}</td>
                        <td>{{ $sales_payment->paymentType ? $sales_payment->paymentType->name : '' }}</td>
                        <td>
                            @foreach($sales_payment->fields as $field)
                                <strong>{{ $field->name }} : </strong>{{ $field->pivot ? $field->pivot->field_value : '' }},
                            @endforeach
                        </td>
                        <td>{{ $sales_payment->amount }}</td>
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
            $("#salesPaymentsTable").dataTable({
                "order": [
                    [ 1, 'desc' ]
                ],
            });
        });

    </script>

@endsection

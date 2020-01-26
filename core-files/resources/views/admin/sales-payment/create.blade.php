@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="text-success">CREATE SALES PAYMENT<a href="{{ route('sales-payments',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-info flat pull-right"><i class="fa fa-plus-circle"></i>SALES PAYMENTS</a></h3>
        </div>
    </div>
    <form action="{{ route('store-sales-payment',['company_id' => Request::segment(2)]) }}" method="post">
        {{ csrf_field() }}
        <create-sales-payment :items="{paymentTypes: {{ $payment_types }},salesOrders: {{ $sales_orders }} }"></create-sales-payment>
    </form>
@endsection


@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            $('.datepicker').datepicker({
                "format": 'yyyy-mm-dd',
                "todayHighlight": true,
                "autoclose": true,
                "startDate": new Date()
            });

        });

    </script>

@endsection

@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="text-success">CREATE PURCHASE PAYMENT<a href="{{ route('purchase-payments',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-info flat pull-right"><i class="fa fa-plus-circle"></i>PURCHASE PAYMENTS</a></h3>
        </div>
    </div>
    <form action="{{ route('store-purchase-payment',['company_id' => Request::segment(2)]) }}" method="post">
        {{ csrf_field() }}
{{--        {{dd($purchase_orders)}}--}}
        <create-purchase-payment :items="{ paymentTypes: {{ $payment_types }} , purchaseOrders: {{ $purchase_orders }} }"></create-purchase-payment>
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
            $("#chalanListTable").dataTable();
            $('.datepicker').datepicker({
                "format": 'yyyy-mm-dd',
                "todayHighlight": true,
                "autoclose": true,
                "startDate": new Date()
            });

        });

    </script>

@endsection

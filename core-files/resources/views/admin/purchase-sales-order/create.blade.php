@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                CREATE PURCHASE SALES ORDER
            </h3>
        </div>
    </div>
    <form action="{{ route('store-purchase-sales-order',['company_id' => Request::segment(2)]) }}" method="post">
        @csrf
        <create-purchase-sales-order :routes="{ getJsonGoodsRoute: '{{ route('purchaseSales.getJsonRemGoodsForPurchaseSale',['company_id' => Request::segment(2)]) }}', getJsonCustomersRoute: '{{ route('purchaseSales.getJsonCustomersForPurchaseSale',['company_id' => Request::segment(2)]) }}' }"></create-purchase-sales-order>
    </form>
@endsection


@section('style')
    <style>
        .datepicker-dropdown{
            z-index: 2000 !important;
        }
    </style>
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
                "autoclose": true
            });
        });
    </script>
@endsection


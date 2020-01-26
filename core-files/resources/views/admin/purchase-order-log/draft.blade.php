@extends('layouts.app')

@section('content')
    <create-log-purchase-order
            :token="'{{ csrf_token() }}'"
            :draft="{{$draft}}"
            :routes="{getJsonVendors: '{{ route('logPurchaseOrders.getJsonVendors', ['company_id' => Request::segment(2)]) }}',
            getJsonCategories: '{{ route('logPurchaseOrders.getJsonCategories', ['company_id' => Request::segment(2)]) }}',
            getJsonGrades: '{{ route('logPurchaseOrders.getJsonGrades', ['company_id' => Request::segment(2)]) }}',
            postJsonLogItem: '{{ route('logPurchaseOrders.postJsonLogItem', ['company_id' => Request::segment(2)]) }}',
            deleteJsonLogItem: '{{ route('logPurchaseOrders.deleteJsonLogItem', ['company_id' => Request::segment(2), 'id'=>'']) }}',
            postJsonSavePurchaseOrder: '{{ route('logPurchaseOrders.postJsonSavePurchaseOrder', ['company_id' => Request::segment(2)]) }}',
            }"

    ></create-log-purchase-order>
@endsection
@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection
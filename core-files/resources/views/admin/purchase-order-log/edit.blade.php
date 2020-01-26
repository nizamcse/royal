@extends('layouts.app')

@section('content')
    <edit-log-purchase-order
            :token="'{{ csrf_token() }}'"
            :log_purchase_order="{{$log_purchase_order}}"
            :routes="{getJsonVendors: '{{ route('logPurchaseOrders.getJsonVendors', ['company_id' => Request::segment(2)]) }}',
            getJsonCategories: '{{ route('logPurchaseOrders.getJsonCategories', ['company_id' => Request::segment(2)]) }}',
            getJsonGrades: '{{ route('logPurchaseOrders.getJsonGrades', ['company_id' => Request::segment(2)]) }}',
            postJsonLogItem: '{{ route('logPurchaseOrders.postJsonLogItem', ['company_id' => Request::segment(2)]) }}',
            deleteJsonLogItem: '{{ route('logPurchaseOrders.deleteJsonLogItem', ['company_id' => Request::segment(2), 'id'=>'']) }}',
            updateJsonPurchaseOrder: '{{ route('logPurchaseOrders.updateJsonPurchaseOrder', ['company_id' => Request::segment(2), 'id' =>'']) }}',
            }"

    ></edit-log-purchase-order>
@endsection
@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection
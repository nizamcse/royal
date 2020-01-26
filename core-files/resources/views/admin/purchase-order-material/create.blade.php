@extends('layouts.app')

@section('content')
    <create-material-purchase-order
            :token="'{{ csrf_token() }}'"
            :routes="{
                getJsonVendors: '{{ route('materialPurchaseOrders.getJsonVendors', ['company_id' => Request::segment(2)]) }}',
                getJsonMaterials: '{{ route('materialPurchaseOrders.getJsonMaterials', ['company_id' => Request::segment(2)]) }}',
                postJsonMaterialItem: '{{ route('materialPurchaseOrders.postJsonMaterialItem', ['company_id' => Request::segment(2)]) }}',
                deleteJsonMaterialItem: '{{ route('materialPurchaseOrders.deleteJsonMaterialItem', ['company_id' => Request::segment(2), 'id'=> '']) }}',
                postJsonSavePurchaseOrder: '{{ route('materialPurchaseOrders.postJsonSavePurchaseOrder', ['company_id' => Request::segment(2)]) }}',


            }"

    ></create-material-purchase-order>
@endsection
@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection
@extends('layouts.app')
{{--{!! $material_purchase_order !!}--}}
@section('content')

    <edit-material-purchase-order
            :token="'{{ csrf_token() }}'"
            :material-purchase-order="{{$material_purchase_order}}"
            :routes="{
                getJsonVendors: '{{ route('materialPurchaseOrders.getJsonVendors', ['company_id' => Request::segment(2)]) }}',
                getJsonMaterials: '{{ route('materialPurchaseOrders.getJsonMaterials', ['company_id' => Request::segment(2)]) }}',
                postJsonMaterialItem: '{{ route('materialPurchaseOrders.postJsonMaterialItem', ['company_id' => Request::segment(2)]) }}',
                deleteJsonMaterialItem: '{{ route('materialPurchaseOrders.deleteJsonMaterialItem', ['company_id' => Request::segment(2), 'id'=> '']) }}',
                updateJsonPurchaseOrder: '{{ route('materialPurchaseOrders.updateJsonPurchaseOrder', ['company_id' => Request::segment(2), 'id' =>'']) }}',
            }"

    ></edit-material-purchase-order>
@endsection
@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection
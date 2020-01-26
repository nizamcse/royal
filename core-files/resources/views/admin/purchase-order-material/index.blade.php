@extends('layouts.app')

@section('content')
    <material-purchase-orders
            :token="'{{ csrf_token() }}'"
            :routes="{ getJsonMaterialPurchaseOrders:'{{ route('materialPurchaseOrders.getJsonMaterialPurchaseOrders', ['company_id' => Request::segment(2)]) }}',
                       getDownloadMaterialPurchaseOrders: { route: '{{ route('materialPurchaseOrders.getDownloadMaterialPurchaseOrders', ['company_id' => Request::segment(2)]) }}', can: {{ Auth::user()->can('can:material-purchase-orders-download',Request::segment(2)) ? 1 : 0 }}},
                       getDownloadMaterialPurchaseOrder: { route: '{{ route('materialPurchaseOrders.getDownloadMaterialPurchaseOrder', ['company_id' => Request::segment(2), 'id' => '']) }}', can: {{ Auth::user()->can('can:material-purchase-order-download',Request::segment(2)) ? 1 : 0 }}},
                       createPurchaseOrder: { route: '{{ route('materialPurchaseOrders.create', ['company_id' => Request::segment(2)]) }}', can: {{ Auth::user()->can('can:material-purchase-order-create',Request::segment(2)) ? 1 : 0 }}},
                       showPurchaseOrder: { route: '{{ route('materialPurchaseOrders.show', ['company_id' => Request::segment(2), 'id' => '']) }}', can: {{ Auth::user()->can('can:material-purchase-order-show',Request::segment(2)) ? 1 : 0 }}},
                       editPurchaseOrder: { route: '{{ route('materialPurchaseOrders.edit', ['company_id' => Request::segment(2), 'id' => '']) }}', can: {{ Auth::user()->can('can:material-purchase-order-edit',Request::segment(2)) ? 1 : 0 }}},
                       deletePurchaseOrder: { route: '{{ route('materialPurchaseOrders.delete', ['company_id' => Request::segment(2), 'id' => '']) }}', can: {{ Auth::user()->can('can:material-purchase-order-delete',Request::segment(2)) ? 1 : 0 }}},
             }"
    >

    </material-purchase-orders>
@endsection
@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection
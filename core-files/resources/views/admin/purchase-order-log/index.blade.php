@extends('layouts.app')

@section('content')
    <log-purchase-orders
            :token="'{{ csrf_token() }}'"
            :routes="{ getJsonLogPurchaseOrders:'{{ route('logPurchaseOrders.getJsonLogPurchaseOrders', ['company_id' => Request::segment(2)]) }}',
                       getDownloadLogPurchaseOrders: { route: '{{ route('logPurchaseOrders.getDownloadLogPurchaseOrders', ['company_id' => Request::segment(2)]) }}', can: {{ Auth::user()->can('can:log-purchase-orders-download',Request::segment(2)) ? 1 : 0 }}},
                       getDownloadLogPurchaseOrder: { route: '{{ route('logPurchaseOrders.getDownloadLogPurchaseOrder', ['company_id' => Request::segment(2), 'id' => '']) }}', can: {{ Auth::user()->can('can:log-purchase-order-download',Request::segment(2)) ? 1 : 0 }}},
                       createPurchaseOrder: { route: '{{ route('logPurchaseOrders.create', ['company_id' => Request::segment(2)]) }}', can: {{ Auth::user()->can('can:log-purchase-order-create',Request::segment(2)) ? 1 : 0 }}},
                       showPurchaseOrder: { route: '{{ route('logPurchaseOrders.show', ['company_id' => Request::segment(2), 'id' => '']) }}', can: {{ Auth::user()->can('can:log-purchase-order-show',Request::segment(2)) ? 1 : 0 }}},
                       editPurchaseOrder: { route: '{{ route('logPurchaseOrders.edit', ['company_id' => Request::segment(2), 'id' => '']) }}', can: {{ Auth::user()->can('can:log-purchase-order-edit',Request::segment(2)) ? 1 : 0 }}},
                       deletePurchaseOrder: { route: '{{ route('logPurchaseOrders.delete', ['company_id' => Request::segment(2), 'id' => '']) }}', can: {{ Auth::user()->can('can:log-purchase-order-delete',Request::segment(2)) ? 1 : 0 }}},
             }"
    >

    </log-purchase-orders>
@endsection
@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection
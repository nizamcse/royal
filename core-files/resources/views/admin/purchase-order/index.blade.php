@extends('layouts.app')

@section('content')
    <purchase-order
            :items="{
            createUrl: '{{ route('create-purchase-order',['company_id' => Request::segment(2)]) }}',
            apiUrl: '{{ route('get-purchase-orders',['company_id' => Request::segment(2)]) }}',
            view: {url: '{{ route('purchase-order',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('purchase-order-show',Request::segment(2)) ? 1 : 0 }} },
            edit: {url: '{{ route('edit-purchase-order',['company_id' => Request::segment(2),'id' => '']) }}',can: 1 },
            download: {url: '{{ route('download-purchase-order',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('purchase-order-download',Request::segment(2)) ? 1 : 0 }} },
            deleteOrder: {url: '{{ route('delete-purchase-order',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('purchase-order-delete',Request::segment(2)) ? 1 : 0 }}} }">
    </purchase-order>
@endsection

@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

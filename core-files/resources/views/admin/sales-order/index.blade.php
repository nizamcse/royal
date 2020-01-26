@extends('layouts.app')

@section('content')
    <sales-order
            :items="{
            createUrl: '{{ route('create-sales-order',['company_id' => Request::segment(2)]) }}',
            apiUrl: '{{ route('get-sales-orders',['company_id' => Request::segment(2)]) }}',
            view: {url: '{{ route('show-sales-order',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('sales-order-show',Request::segment(2)) ? 1 : 0 }} },
            download: {url: '{{ route('download-sales-order',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('sales-order-download',Request::segment(2)) ? 1 : 0 }} },
            deleteOrder: {url: '{{ route('delete-sales-order',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('sales-order-delete',Request::segment(2)) ? 1 : 0 }}} }">
    </sales-order>
@endsection

@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection


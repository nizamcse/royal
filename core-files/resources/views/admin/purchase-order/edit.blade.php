@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                CREATE PURCHASE ORDER
                <a href="{{ route('purchase-orders',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> PURCHASE ORDERS
                </a>
            </h3>
        </div>
        <div class="box-body">
            <edit-purchase-order :items="{grades:{{ $grades }},rawMaterials: {{ $raw_materials }},vendors: {{ $vendors }},token: '{{ csrf_token() }}',categories: {{ $categories }},formUrl: '{{ route('update-purchase-order',['company_id' => Request::segment(2),'id' => $purchase_order->id]) }}',apiUrl: '{{ route('get-purchased-items',['company_id' => Request::segment(2),'id' => $purchase_order->id]) }}' }"></edit-purchase-order>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}">
    </script>
@endsection
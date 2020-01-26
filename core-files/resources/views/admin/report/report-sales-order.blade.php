@extends('layouts.app')

@section('content')
    <report-sales-order
            :items="{ companyName:'{{ $company_name }}',  }"
            :routes="{ getJsonGoodsRoute:'{{ route('reports.getJsonGoodsForSalesOrderReport', ['company_id' => Request::segment(2)]) }}',
            getJsonCustomersRoute:'{{ route('reports.getJsonCustomersForSalesOrderReport', ['company_id' => Request::segment(2)]) }}',
            postJsonSalesOrderReportRoute: '{{ route('reports.postJsonSalesOrderReport', ['company_id' => Request::segment(2)]) }}',
            getDownloadSalesOrderReportRoute: { route: '{{ route('reports.getDownloadSalesOrderReport', ['company_id' => Request::segment(2)]) }}', can: {{ Auth::user()->can('can:show-sales-orders-report',Request::segment(2)) ? 1 : 0 }} },
             }"></report-sales-order>
@endsection
@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection
@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                ACCOUNTS CLOSING
                <a href="{{ route('account-closings',['company_id' => Request::segment(2)]) }}" class="btn btn-xs flat pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> ACCOUNTS CLOSINGS
                </a>
            </h3>
        </div>
    </div>
    <create-account-closing :items="{checkingUrl: '{{ route('check-account-closing',['company_id' => Request::segment(2),'year' => '']) }}',startMonth: '{{ $start }}',endMonth: '{{ $end }}',storingUrl: '{{ route('store-account-closing',['company_id' => Request::segment(2)]) }}' }"></create-account-closing>
@endsection


@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

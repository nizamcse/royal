@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                CREATE TRANSACTION
                <a href="{{ route('transactions',['company_id' => Request::segment(2)]) }}" class="btn btn-info btn-sm pull-right"> <i class="fa fa-list"></i> Transactions</a>
            </h3>
        </div>
    </div>
    <form action="{{ route('store-transaction',['company_id' => Request::segment(2)]) }}" method="post">
        @csrf
        <create-transaction :items="{accounts: {{ $accounts }},companies: {{ $companies }} }"></create-transaction>
    </form>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

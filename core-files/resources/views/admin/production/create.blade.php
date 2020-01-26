@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                CREATE PRODUCTION
            </h3>
        </div>
    </div>
    <form action="{{ route('store-production',['company_id' => Request::segment(2)]) }}" method="post">
        @csrf
        <create-production :items="{materialUrl: '{{ route('purchaseSales.getJsonRemGoodsForPurchaseSale',['company_id' => Request::segment(2)]) }}',logs: {{ $logs }} }"></create-production>
    </form>
@endsection


@section('script')
    <script>
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

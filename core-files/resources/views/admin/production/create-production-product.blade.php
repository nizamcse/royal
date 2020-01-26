@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>PRODUCTION SUMMARY</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <p>START AT</p>
                    <span>{{ $production->start_at }}</span>
                </div>
                <div class="col-md-3">
                    <p>END AT</p>
                    <span>{{ $production->end_at }}</span>
                </div>
                <div class="col-md-3">
                    <p>GOOD PRODUCED</p>
                    <span>{{ $production->good_produced ? 'YES' : 'NO' }}</span>
                </div>
                <div class="col-md-3">
                    <p>TOTAL PRODUCTION COST</p>
                    <span>{{ $production->total_production_cost }}</span>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('store-production-product',['company_id' => Request::segment(2),'id' => $production->id]) }}" method="post">
        @csrf
        <create-production-product :items="{goods: {{ $goods  }} }"></create-production-product>
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

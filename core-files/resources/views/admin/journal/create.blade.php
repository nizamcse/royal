@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                CREATE JOURNAL
                <a href="{{ route('journals',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> JOURNALS
                </a>
            </h3>
        </div>
    </div>
    <form action="{{ route('store-journal',['company_id' => Request::segment(2)]) }}" method="post">
        @csrf
        <create-journal :items="{accounts: {{ $accounts }} }"></create-journal>
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

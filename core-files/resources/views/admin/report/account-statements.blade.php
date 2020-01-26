@extends('layouts.app')

@section('content')
    <account-statement :items="{apiUrl: '{{ route('get-account-statements',['company_id' => Request::segment(2)]) }}'}"></account-statement>
@endsection


@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

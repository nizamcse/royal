<?php
/**
 * Created by PhpStorm.
 * User: Sakir
 * Date: 07-Dec-19
 * Time: 3:07 PM
 */
@extends('layouts.app')

@section('content')
    <report-purchase-order
        :items="{ companyName:'{{ $company_name }}' }"></report-purchase-order>
@endsection
@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

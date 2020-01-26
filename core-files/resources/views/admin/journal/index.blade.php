@extends('layouts.app')

@section('content')
    <journals
            :items="{
            createUrl: '{{ route('create-journal',['company_id' => Request::segment(2)]) }}',
            downloadUrl: '{{ route('download-journal-entries',['company_id' => Request::segment(2)]) }}',
            apiUrl: '{{ route('get-journal-entries',['company_id' => Request::segment(2)]) }}',
            editJournal: {url: '{{ route('edit-journal',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('purchase-order-show',Request::segment(2)) ? 1 : 0 }} },
            deleteJournal: {url: '{{ route('delete-journal',['company_id' => Request::segment(2),'id' => '']) }}',can: {{ Auth::user()->can('purchase-order-delete',Request::segment(2)) ? 1 : 0 }}} }">
    </journals>
@endsection

@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

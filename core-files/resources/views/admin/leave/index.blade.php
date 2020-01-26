@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                LIST OF EMPLOYEE LEAVES
                <a href="{{ route('create-leave',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> CREATE LEAVE
                </a>
            </h4>
        </div>
        <leave :items="{apiUrl: '{{ route('get-leaves',['company_id' => Request::segment(2)]) }}',linkE: '{{  route('edit-leave',['company_id' => Request::segment(2),'id' => '']) }}',linkD: '{{  route('delete-leave',['company_id' => Request::segment(2),'id' => '']) }}' }"></leave>
    </div>
@endsection

@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

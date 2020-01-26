@extends('layouts.admin')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Company Details <a href="{{ route('companies') }}" class="btn btn-sm btn-info pull-right">Companies</a></h3>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div>
        <div class="box-body">
            <table class="table">
                <tr>
                    @if($company->logo)
                        <td><img src="{{ asset($company->logo) }}" alt="" class="img-responsive"></td>
                    @endif
                    <td>Name: {{ $company->name }}</td>
                    <td>Contact No: {{ $company->contact_no }}</td>
                    <td>Address: {{ $company->address }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection


@section('styles')
@endsection


@section('script')
    {{--<script src="{{ asset('core-files/public/js/app.js') }}"></script>--}}
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection

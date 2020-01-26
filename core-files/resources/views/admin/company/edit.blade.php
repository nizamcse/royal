@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3>UPDATE COMPANY <a href="{{ route('companies') }}" class="btn btn-sm btn-info pull-right">Companies</a></h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">COMPANY INFORMATION</h4>
                        </div>
                        <div class="box-body">
                            <form action="{{ route('update-company',['company_id' => $company->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <update-company :items="{company: {{ $company }},user: {{ $company->admin->first() ?? '{}' }},apiUrl:'{{ route('get-admins') }}' }"></update-company>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <update-password :items="{companyId: {{ $company->id }},apiUrl:'{{ route('update-company-user-pass') }}' }"></update-password>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
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

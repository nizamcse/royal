@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3>CREATE NEW COMPANY <a href="{{ route('companies') }}" class="btn btn-sm btn-info pull-right">Companies</a></h3>
                </div>
            </div>

            <form action="{{ route('store-company') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box">
                    <div class="box-header">
                        <h4>COMPANY INFORMATION</h4>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Company Name *</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact No</label>
                                            <input type="text" class="form-control" name="contact_no" value="{{ old('contact_no') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="company_email">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Upload Logo</label>
                                            <input type="file" name="logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4>ACCOUNT INFORMATION</h4>
                    </div>
                    <create-company :items="{apiUrl: '{{ route('search-user') }}' }"></create-company>
                </div>
            </form>
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

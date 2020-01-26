@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                ACCOUNTS SETTINGS
            </h3>
        </div>
        <div class="box-body">
            @if(session('message'))
                <div class="alert {{ session('message')['status'] ? 'alert-success' : 'alert-danger' }} alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {{ session('message')['text'] ?? '' }}
                </div>
            @endif
            <form action="{{ route('update-account-setting',['company_id' => Request::segment(2)]) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>ACCOUNTS CLOSING START FROM</label>
                            <select name="start_month" class="form-control" required>
                                <option value="">-- Select Month --</option>
                                <option value="01" {{ $start_month == '01' ? 'selected="seledted"' : '' }}>January</option>
                                <option value="02"  {{ $start_month == '02' ? 'selected="seledted"' : '' }}>February</option>
                                <option value="03"  {{ $start_month == '03' ? 'selected="seledted"' : '' }}>March</option>
                                <option value="04"  {{ $start_month == '04' ? 'selected="seledted"' : '' }}>April</option>
                                <option value="05"  {{ $start_month == '05' ? 'selected="seledted"' : '' }}>May</option>
                                <option value="06"  {{ $start_month == '06' ? 'selected="seledted"' : '' }}>June</option>
                                <option value="07"  {{ $start_month == '07' ? 'selected="seledted"' : '' }}>July</option>
                                <option value="08"  {{ $start_month == '08' ? 'selected="seledted"' : '' }}>August</option>
                                <option value="09"  {{ $start_month == '09' ? 'selected="seledted"' : '' }}>September</option>
                                <option value="10"  {{ $start_month == '10' ? 'selected="seledted"' : '' }}>October</option>
                                <option value="11"  {{ $start_month == '11' ? 'selected="seledted"' : '' }}>November</option>
                                <option value="12"  {{ $start_month == '12' ? 'selected="seledted"' : '' }}>December</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>ACCOUNTS CLOSING ENDING MONTH</label>
                            <select name="end_month" class="form-control" required>
                                <option value="">-- Select Month --</option>
                                <option value="01" {{ $end_month == '01' ? 'selected="seledted"' : '' }}>January</option>
                                <option value="02"  {{ $end_month == '02' ? 'selected="seledted"' : '' }}>February</option>
                                <option value="03"  {{ $end_month == '03' ? 'selected="seledted"' : '' }}>March</option>
                                <option value="04"  {{ $end_month == '04' ? 'selected="seledted"' : '' }}>April</option>
                                <option value="05"  {{ $end_month == '05' ? 'selected="seledted"' : '' }}>May</option>
                                <option value="06"  {{ $end_month == '06' ? 'selected="seledted"' : '' }}>June</option>
                                <option value="07"  {{ $end_month == '07' ? 'selected="seledted"' : '' }}>July</option>
                                <option value="08"  {{ $end_month == '08' ? 'selected="seledted"' : '' }}>August</option>
                                <option value="09"  {{ $end_month == '09' ? 'selected="seledted"' : '' }}>September</option>
                                <option value="10"  {{ $end_month == '10' ? 'selected="seledted"' : '' }}>October</option>
                                <option value="11"  {{ $end_month == '11' ? 'selected="seledted"' : '' }}>November</option>
                                <option value="12"  {{ $end_month == '12' ? 'selected="seledted"' : '' }}>December</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-sm btn-success" type="submit">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection


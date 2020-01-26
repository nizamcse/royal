@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header"><h4>ATTENDANCE SHEET<a href="{{ route('attendances',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-info pull-right">Attendances</a> </h4></div>
        <form action="{{ route('store-attendance',['company_id' => Request::segment(2)]) }}" method="post">
            @csrf
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <div class="form-group">
                                <label>Attendance Date</label>
                                <input type="text" class="form-control datepicker" name="attendance_date" autocomplete="off">
                            </div>
                        </th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>Employee</th>
                        <th>In Time</th>
                        <th>Exit Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $k => $employee)
                        <tr>
                            <td>{{ $employee->name }} <input type="hidden" name="attendance[{{ $k }}][employee_id]" value="{{ $employee->id }}"></td>
                            <td><date-time :inputs="{format: 'HH:mm',name: 'attendance[{{ $k }}][in_time]' }"></date-time></td>
                            <td><date-time :inputs="{format: 'HH:mm',name: 'attendance[{{ $k }}][exit_time]' }"></date-time></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="form-group text-right" style="margin-top: 30px">
                    <button class="btn btn-success btn-sm" type="submit">Create Attendance</button>
                </div>
            </div>
        </form>
    </div>

@endsection


@section('styles')
@endsection


@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                "format": 'yyyy-mm-dd',
                "todayHighlight": true,
                "autoclose": true
            });
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection

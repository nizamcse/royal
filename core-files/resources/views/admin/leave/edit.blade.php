@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                EDIT EMPLOYEE LEAVE
                <a href="{{ route('leaves',['company_id' => Request::segment(2)]) }}" class="btn btn-info btn-sm pull-right"> <i class="fa fa-list"></i> Leaves</a>
            </h3>
        </div>
    </div>
    <form action="{{ route('update-leave',['company_id' => Request::segment(2),'id' => $leave->id]) }}" method="post">
        @csrf
        <create-leave
                :items="{employees: {{ $employees }},leaveTypes: {{ $leave_types }},employeeLeave:{{ $leave }} }">
        </create-leave>
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

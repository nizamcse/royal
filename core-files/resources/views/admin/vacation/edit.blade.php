@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                UPDATE VACATION
                <a href="{{ route('vacations',['company_id' => Request::segment(2)]) }}" class="btn btn-info btn-sm pull-right"> <i class="fa fa-list"></i> Vacations</a>
            </h3>
        </div>
    </div>
    <form action="{{ route('update-vacation',['company_id' => Request::segment(2),'id' => $vacation->id]) }}" method="post">
        @csrf
        <vacation-form :items="{vacation: {{ $vacation }}}"></vacation-form>
    </form>
@endsection


@section('script')
    <script type="text/javascript">
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

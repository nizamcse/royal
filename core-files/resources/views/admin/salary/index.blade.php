@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                FIND THE SALARY SHEET
                <a href="{{ route('create-salary',['company_id' => Request::segment(2)]) }}"
                   class="btn btn-sm pull-right btn-info flat">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </a>
            </h3>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#vacationss-table').DataTable()
        });
    </script>
@endsection

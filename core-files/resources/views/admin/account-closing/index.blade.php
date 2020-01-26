@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF ACCOUNT CLOSINGS
                <a href="{{ route('create-account-closing',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </a>
            </h3>
        </div>
        <div class="box-body">
            <table id="account-closings-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>CLOSING MONTHS</th>
                    <th>CLOSING YEAR</th>
                    <th>CLOSED BY</th>
                    <th>CLOSED AT</th>
                </tr>
                </thead>
                <tbody>
                @foreach($account_closings as $k => $account_closing)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $account_closing->closing_start_from .'-'.$account_closing->closing_ends_at }}</td>
                        <td>{{ $account_closing->closing_start_year == $account_closing->closing_end_year ? $account_closing->closing_end_year : $account_closing->closing_start_year .'-'.$account_closing->closing_end_year }}</td>
                        <td>{{ $account_closing->user->name ?? 'Unknown' }}</td>
                        <td>{{ $account_closing->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#account-closings-table').DataTable()
        });
    </script>
@endsection

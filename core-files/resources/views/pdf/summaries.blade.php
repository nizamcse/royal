@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h2><strong>SALES ORDER </strong>(<small>Sold Out Date : <strong></strong></small>)</h2>
        <div>
            <h4>CUSTOMER DETAILS</h4>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Company Name: </strong></td>
                    <td><strong>Address: </strong> </td>
                    <td><strong>Customer Name: </strong></td>
                </tr>
            </table>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Summary Type:  </strong>{{ $filter_type->name ?? "All Type"}}</td>
                    <td><strong>From Date: </strong> {{ $date_form }}</td>
                    <td><strong>To Date: </strong> {{ $to_date }}</td>
                </tr>
            </table>
        </div>

        <div>
            <h4>Summary details</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Summary Type</th>
                        <th>Divided</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($summaries as $k => $summary)
                    <tr>
                        <td>{{ $summary->summary_data->format('d M, Y') }}</td>
                        <td>{{ $summary->summeryType->name }}</td>
                        <td>{{ $summary->receive }}</td>
                        <td>{{ $summary->payment }}</td>
                        <td class="{{ ($summary->balance > 0 ) ? 'text-success text-bold' : 'text-danger text-bold' }}">{{ $summary->balance }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

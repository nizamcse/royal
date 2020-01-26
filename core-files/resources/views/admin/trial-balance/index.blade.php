@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                TRIAL BALANCE
                <a href="{{ route('download-trial-balance',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-success pull-right btn-flat" target="_blank"><i class="fa fa-download"></i> Download</a>
            </h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SL#</th>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $debit = 0;
                        $credit = 0;
                    @endphp
                    @foreach($accounts as $k => $account)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $account->name }}</td>
                            @if($account->journals->sum('credit') > $account->journals->sum('debit'))
                                @php
                                    $credit = $credit + $account->journals->sum('credit') - $account->journals->sum('debit');
                                @endphp
                                <td></td>
                                <td class="text-right">{{ number_format($account->journals->sum('credit') - $account->journals->sum('debit'),2) }}</td>
                            @else
                                @php
                                    $debit = $debit + $account->journals->sum('debit') - $account->journals->sum('credit');
                                @endphp
                                <td class="text-right">{{ number_format($account->journals->sum('debit') - $account->journals->sum('credit'),2) }}</td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="bg-success text-right">{{ number_format($debit,2) }}</td>
                        <td class="bg-success text-right">{{ number_format($credit,2) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection

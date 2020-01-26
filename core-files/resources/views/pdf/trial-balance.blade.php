@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h4>
            TRIAL BALANCE
        </h4>
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
@endsection
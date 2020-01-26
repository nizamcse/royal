@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>LEDGER FOR - {{ $account->name }} [ {{ Config::get('enums.account_types')[$account->type] ?? '' }}]</h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="2">Debit</th>
                        <th colspan="2">Credit</th>
                    </tr>
                    <tr>
                        <th>Account</th>
                        <th>Amount</th>
                        <th>Account</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($journals as $journal)
                        <tr>
                            @if($journal->account_type)
                                <td>{{ $journal->journal->account ? $journal->journal->account->name : '' }}</td>
                                <td class="text-right">{{ number_format($journal->credit,2) }}</td>
                                <td></td>
                                <td></td>
                            @else
                                <td></td>
                                <td></td>
                                <td>{{ $journal->journal->account ? $journal->journal->account->name : '' }}</td>
                                <td class="text-right">{{ number_format($journal->debit,2) }}</td>
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <td>{{ $account->journals->sum('credit') < $account->journals->sum('debit') ? 'Balance b/d' : '' }}</td>
                        <td class="text-right">
                            @if($account->journals->sum('credit') < $account->journals->sum('debit'))
                                {{ number_format($account->journals->sum('debit') - $account->journals->sum('credit'),2) }}
                            @endif
                        </td>
                        <td>{{ $account->journals->sum('credit') > $account->journals->sum('debit') ? 'Balance c/d' : '' }}</td>
                        <td class="text-right">
                            @if($account->journals->sum('credit') > $account->journals->sum('debit'))
                                {{ number_format($account->journals->sum('credit') - $account->journals->sum('debit'),2) }}
                            @endif
                        </td>
                    </tr>
                    <tr class="bg-info">
                        <td colspan="3">
                            {{ $account->journals->sum('credit') < $account->journals->sum('debit') ? 'Balance b/d' : 'Balance c/d' }}
                        </td>
                        <td class="text-right">
                            @if($account->journals->sum('credit') > $account->journals->sum('debit'))
                                {{ number_format($account->journals->sum('credit') - $account->journals->sum('debit'),2) }}
                            @else
                                {{ number_format($account->journals->sum('debit') - $account->journals->sum('credit'),2) }}
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
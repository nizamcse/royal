@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                LEDGER FOR - {{ $account->name }} [ {{ Config::get('enums.account_types')[$account->type] ?? '' }}]
                <a href="{{ route('download-ledger',['company_id' => Request::segment(2),'id' => $account->id]) }}" class="btn btn-sm btn-success pull-right btn-flat" target="_blank"><i class="fa fa-download"></i> Download</a>
            </h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Date</th>
                        <th>Account</th>
                        <th>Debit (Dr)</th>
                        <th>Credit (Cr)</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $balance = 0;
                    @endphp
                    @foreach($journals as $k => $journal)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td>{{ $journal->journal_date }}</td>
                            <td>
                                {{ $journal->journal->account->name ?? '' }}
                                @if($journal->journalEntry)
                                    @if($journal->journalEntry->narration)
                                        [ {{ $journal->journalEntry->narration }} ]
                                    @endif
                                @endif
                            </td>
                            @if($journal->account_type)
                                @php
                                    $balance -= $journal->credit;
                                @endphp
                                <td class="text-right">0.00</td>
                                <td class="text-right">{{ number_format($journal->credit,2) }}</td>
                                <td class="text-danger text-right">{{ number_format($balance,2) }}</td>
                            @else
                                @php
                                    $balance += $journal->debit;
                                @endphp
                                <td class="text-right">{{ number_format($journal->debit,2) }}</td>
                                <td class="text-right">0.00</td>
                                <td class="text-success text-right">{{ number_format($balance,2) }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection


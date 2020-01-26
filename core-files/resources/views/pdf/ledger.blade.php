@extends('layouts.download')

@section('content')
    <div class="box-body">
        <table class="table border-none mb-30">
            <tbody>
            <tr>
                <td><strong>Account Name: </strong>{{ $account->name }}</td>
                <td><strong>Account Type: </strong>{{ Config::get('enums.account_types')[$account->type] ?? '' }}</td>
                <td>Report For Date: ALL</td>
            </tr>
            </tbody>
        </table>
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
@endsection
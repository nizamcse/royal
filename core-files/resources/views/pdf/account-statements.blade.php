@extends('layouts.download')

@section('content')
    <div class="box-body">
        <h4 class="text-center text-uppercase">ACCOUNT STATEMENT REPORT</h4>
        <table class="table border-none mb-30">
            <tbody>
            <tr>
                <td><strong>Account Type</strong>: {{  $account_type  }}</td>
                <td>Date From: {{ \Carbon\Carbon::parse($from_date)->format('jS F Y') }}</td>
                <td>Date To: {{ \Carbon\Carbon::parse($from_date)->format('jS F Y') }}</td>
            </tr>
            </tbody>
        </table>
        <p class="text-center"></p>
        <hr>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>Date</th>
                <th>Account</th>
                <th class="text-right">Debit (Dr)</th>
                <th class="text-right">Credit (Cr)</th>
                <th class="text-right">Balance</th>
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
                        {{ $journal->journal->account ? $journal->journal->account->name : '' }}
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
@extends('layouts.pad')

@section('content')
    <div class="box-body">
        <h4>JOURNAL ENTRY LIST</h4>
        @foreach($journal_entries as $journals)
            <table class="table table-bordered table-striped page-break">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>ID</th>
                    <th>Narration</th>
                    <th class="w-200px">Account</th>
                    <th class="w-100px">Debit</th>
                    <th class="w-100px">Credit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($journals as $k => $journal_entry)
                    <tr class="event">
                        <td rowspan="2">{{ $journal_entry->journal_date }}</td>
                        <td rowspan="2">{{ $journal_entry->id }}</td>
                        <td rowspan="2">{{ $journal_entry->narration }}</td>
                        <td>{{ $journal_entry->debit_row ? $journal_entry->debit_row->account ? $journal_entry->debit_row->account->name : '' : '' }}</td>
                        <td class="text-right">{{ $journal_entry->debit_row ? number_format($journal_entry->debit_row->debit,2) : '' }}</td>
                        <td></td>
                    </tr>
                    <tr class="odd">
                        <td>{{ $journal_entry->credit_row ? $journal_entry->credit_row->account ? $journal_entry->credit_row->account->name : '' : '' }}</td>
                        <td></td>
                        <td class="text-right">{{ $journal_entry->credit_row ? number_format($journal_entry->credit_row->credit,2) : '' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach

    </div>
@endsection

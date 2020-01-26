@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>JOURNAL DETAIL</h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Narration</th>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td rowspan="2">{{ $journal_entry->journal_date }}</td>
                        <td rowspan="2">{{ $journal_entry->narration }}</td>
                        <td>{{ $journal_entry->debit_row ? $journal_entry->debit_row->account ? $journal_entry->debit_row->account->name : '' : '' }}</td>
                        <td>{{ $journal_entry->debit_row ? $journal_entry->debit_row->debit : '' }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{ $journal_entry->credit_row ? $journal_entry->credit_row->account ? $journal_entry->credit_row->account->name : '' : '' }}</td>
                        <td></td>
                        <td>{{ $journal_entry->credit_row ? $journal_entry->credit_row->credit : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection

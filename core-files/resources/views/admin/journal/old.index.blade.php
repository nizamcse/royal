@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                JOURNAL ENTRY LIST
                <a href="{{ route('create-journal',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> CREATE JOURNAL
                </a>
            </h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Narration</th>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th class="text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($journal_entries as $journal_entry)
                        <tr>
                            <td rowspan="2">{{ $journal_entry->journal_date }}</td>
                            <td rowspan="2">{{ $journal_entry->id }}</td>
                            <td rowspan="2">{{ $journal_entry->narration }}</td>
                            <td>{{ $journal_entry->debit_row ? $journal_entry->debit_row->account ? $journal_entry->debit_row->account->name : '' : '' }}</td>
                            <td class="text-right">{{ $journal_entry->debit_row ? number_format($journal_entry->debit_row->debit,2) : '' }}</td>
                            <td></td>
                            <td rowspan="2" class="text-right" style="vertical-align: middle">
                                <a href="{{ route('edit-journal',['company_id' => Request::segment(2),'id' => $journal_entry->id]) }}" class="btn btn-warning btn-xs btn-flat">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <button data-url="{{ route('delete-journal',['company_id' => Request::segment(2),'id' => $journal_entry->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ $journal_entry->credit_row ? $journal_entry->credit_row->account ? $journal_entry->credit_row->account->name : '' : '' }}</td>
                            <td></td>
                            <td class="text-right">{{ $journal_entry->credit_row ? number_format($journal_entry->credit_row->credit,2) : '' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $journal_entries->links() }}
            </div>
        </div>
    </div>


@endsection

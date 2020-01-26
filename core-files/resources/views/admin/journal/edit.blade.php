@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                UPDATE JOURNAL
                <a href="{{ route('journals',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> JOURNALS
                </a>
            </h3>
        </div>
    </div>
    <form action="{{ route('update-journal',['company_id' => Request::segment(2),'id' => $journal_entry->id]) }}" method="post">
        @csrf
        <input type="hidden" name="debit_id" value="{{ $journal_entry->debit_row->id }}">
        <input type="hidden" name="credit_id" value="{{ $journal_entry->credit_row->id }}">
        <update-journal
                :items="{accounts: {{ $accounts }},
                journal: {{ $journal_entry }},
                debit: {{ $journal_entry->debit_row->account }},
                amount: {{ $journal_entry->debit_row->debit }},
                credit: {{ $journal_entry->credit_row->account }} }">

        </update-journal>
    </form>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
@endsection

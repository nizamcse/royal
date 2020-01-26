@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                TRANSACTIONS
                <a href="{{ route('create-transaction',['company_id' => Request::segment(2)]) }}" class="btn btn-info btn-sm pull-right"> <i class="fa fa-plus-circle"></i> Create New</a>
            </h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Request Type</th>
                        <th>Journal ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            @if($transaction->sender->id == Request::segment(2))
                                <td>{{ $transaction->receiver ? $transaction->receiver->name : '' }}</td>
                            @else
                                <td>{{ $transaction->sender->name }}</td>
                            @endif
                            <td>{{ $transaction->sender->id == Request::segment(2) ? 'OUT' : 'IN' }}</td>
                            @if($transaction->sender->id == Request::segment(2))
                                <td><a href="{{ route('show-journal',['company_id' => Request::segment(2),'id' => $transaction->journalFrom->id]) }}">{{ $transaction->journalFrom->id }}</a></td>
                            @else
                                @if($transaction->journalTo)
                                    <td><a href="{{ route('show-journal',['company_id' => Request::segment(2),'id' => $transaction->journalTo->id]) }}">{{ $transaction->journalTo->id }}</a></td>
                                @else
                                    <td></td>
                                @endif
                            @endif

                            <td>{{ $transaction->amount }}</td>
                            <td>
                                @if($transaction->sender->id == Request::segment(2))
                                    {{ $transaction->status ? 'Approved' : 'Not Approved' }}
                                @else
                                    @if($transaction->status)
                                        Approved
                                    @else
                                        <a href="{{ route('approve-transaction',['company_id' => Request::segment(2),'id' => $transaction->id]) }}">Approve</a>
                                    @endif
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection

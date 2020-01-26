@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF SUMMARY
                <a type="button" class="btn btn-sm pull-right btn-success" href="{{ route('summaries.downloads',['company_id' => Request::segment(2), 'summary_type' => Request::get('summary_type'), 'from_date' => Request::get('from_date'), 'end_date' => Request::get('end_date') ]) }}" target='_blank'>
                    <i class="fa fa-download"></i> DOWNLOAD
                </a>
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#expense-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
            @include('msg')
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="get">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Summary Type</label>
                                    <select name="summary_type" class="form-control">
                                        <option value="">All Summary Type</option>
                                        @foreach($summary_types as $summary_type)
                                            <option @if(Request::get('summary_type') == $summary_type->id ) selected @endif value="{{ $summary_type->id }}">{{ $summary_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Start date (Form)</label>
                                    <input type="text" name="from_date" value="{{ Request::get('from_date') }}" class="form-control datepicker_filter" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>End Date(To)</label>
                                    <input type="text" name="end_date" value="{{ Request::get('end_date') }}" class="form-control datepicker_filter" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <p style="margin-bottom:5px;">&nbsp;</p>
                                <button type="submit" class="btn btn-primary btn-flat">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        <div class="box-body">
            <table id="expenses-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>DATE</th>
                    <th>Summary type</th>
                    <th>Comment</th>
                    <th>Divided</th>
                    <th>Credit</th>
                    <th>Balance</th>
                </tr>
                </thead>
                <tbody>
                @foreach($summaries as $k => $summary)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $summary->summary_data->format('d M, Y') }}</td>
                        <td>{{ $summary->summeryType->name }}</td>
                        <td>{{ $summary->comment }}</td>
                        <td>{{ $summary->receive }}</td>
                        <td>{{ $summary->payment }}</td>
                        <td class="{{ ($summary->balance > 0 ) ? 'text-success text-bold' : 'text-danger text-bold' }}">{{ $summary->balance }}</td>
                    </tr>
                @endforeach
                </tbody>



            </table>
            <div class="text-center">
                {{ $summaries->links() }}
            </div>
        </div>
    </div>
    {{-----------------------------create model----------------------------------------}}
    <div class="modal fade in" id="expense-modal" tabindex="-1" role="dialog" aria-labelledby="expense">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('summaries.create',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE SUMMARY</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Summary Type</label>
                            <select name="summary_type_id" class="form-control">
                                <option value="">Select Summary Type</option>
                                @foreach($summary_types as $summary_type)
                                    <option value="{{ $summary_type->id }}">{{ $summary_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" name="summary_data" class="form-control datepicker" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Details</label>
                            <textarea name="comment" cols="30" rows="5" class="form-control"></textarea>
                        </div>

                        <!-- radio -->
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label"><input class="form-check-input" type="radio" name="type" value="receive"> Receive</label>
                                <label class="form-check-label"><input class="form-check-input" type="radio" name="type" value="payment"> Payment</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-flat">CREATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{---------------------------------Update Model-----------------------------------}}

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });


            // $('#expenses-table').DataTable()

            $(".datepicker").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
            });

            $(".datepicker_filter").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
            });
        });
    </script>
@endsection



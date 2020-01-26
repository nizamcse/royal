@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="text-success">SALES CHALAN LISTS<a href="{{ route('create-chalan',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-info flat pull-right"><i class="fa fa-plus-circle"></i> CREATE NEW CHALAN</a></h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped" id="chalanListTable">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>CH No Auto</th>
                    <th>CH No Manual</th>
                    <th>Sales Order No</th>
                    <th>Chalan Date</th>
                    <th class="text-right">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($chalans as $k => $chalan)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td><a href="{{ route('get-chalan',['company_id' => Request::segment(2),'id' => $chalan->id]) }}">{{ $chalan->chalan_no }}</a></td>
                        <td>{{ $chalan->chalan_no_manual }}</td>
                        <td>{{ $chalan->salesOrder->id }}</td>
                        <td>{{Carbon\Carbon::parse( $chalan->chalan_date)->format('d F Y') }}</td>
                        <td class="text-right">
                            <a href="{{ route('download-sales-chalan',['company_id' => Request::segment(2),'id' => $chalan->id]) }}" class="btn btn-xs btn-success btn-flat" target="_blank"><i class="fa fa-download"></i> Download</a>
                            <a href="{{ route('download-sales-chalan-bill',['company_id' => Request::segment(2),'id' => $chalan->id]) }}" class="btn btn-xs btn-success btn-flat" target="_blank"><i class="fa fa-download"></i> Get Bill</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#chalanListTable").dataTable();
        });

    </script>

@endsection

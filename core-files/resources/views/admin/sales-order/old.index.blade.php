@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF SALES ORDER
                <a href="{{ route('create-purchase-sales-order',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </a>
            </h3>
        </div>
        <div class="box-body">
            <table id="sales-orders" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>#ORDER ID</th>
                    <th>DATE</th>
                    <th>CUSTOMER NAME</th>
                    <th>CONTACT NO</th>
                    <th>AMOUNT</th>
                    <th class="text-right">ACTION</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sales_orders as $k => $sales_order)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $sales_order->id }}</td>
                        <td>{{ $sales_order->sold_out_date }}</td>
                        <td>{{ $sales_order->name }}</td>
                        <td>{{ $sales_order->contact_no  }}</td>
                        <td>{{ $sales_order->total_amount  }}</td>
                        <td class="text-right">
                            <a href="{{ route('show-sales-order',['company_id' => Request::segment(2),'id' => $sales_order->id]) }}" class="btn btn-xs btn-info"><i class="fa fa-expand"></i> View</a>
                            <a href="{{ route('download-sales-order',['company_id' => Request::segment(2),'id' => $sales_order->id]) }}" class="btn btn-xs btn-success" target="_blank"><i class="fa fa-download"></i> Download</a>
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
        $(document).ready(function () {
            $('#sales-orders').DataTable()
        });
    </script>
@endsection


extends('layouts.app')

@section('content')
    <purchase-order :items="{createUrl: '{{ route('create-purchase-order',['company_id' => Request::segment(2)]) }}',apiUrl: ''}"></purchase-order>
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF PURCHASE ORDERS
                <a href="{{ route('create-purchase-order',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </a>
            </h3>
        </div>
        <div class="box-body">
            <table id="po-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>PO NO</th>
                    <th>CH NO</th>
                    <th>Vendor</th>
                    <th>Amount</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchase_orders as $k => $purchase_order)
                    <tr>
                        <td>{{ $purchase_order->id }}</td>
                        <td>{{ $purchase_order->challan_no_mannual }}</td>
                        <td>{{ $purchase_order->vendorName() }}</td>
                        <td>{{ $purchase_order->amount }}</td>
                        <td>{{ $purchase_order->paid_amount }}</td>
                        <td>{{ $purchase_order->due_amount }}</td>
                        <td class="text-right">
                            <a href="{{ route('purchase-order',['company_id' => Request::segment(2),'id' => $purchase_order->id]) }}" class="btn btn-info btn-xs">View</a>
                            <button data-url="{{ route('delete-purchase-order',['company_id' => Request::segment(2),'id' => $purchase_order->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                            <a href="{{ route('download-purchase-order',['company_id' => Request::segment(2),'id' => $purchase_order->id]) }}" class="btn btn-success btn-xs" target="_blank"> <i class="fa fa-download"></i> Download</a>
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
            $('#po-table').DataTable()
        });
    </script>
@endsection

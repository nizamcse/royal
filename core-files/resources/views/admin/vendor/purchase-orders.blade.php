@extends('layouts.app')

@section('content')
    <div class="box box-info" style="padding-top: 15px;background-color: transparent; box-shadow: none">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Purchases</span>
                        <span class="info-box-number"> {{ $vendor_total_purchase_number }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-usd" aria-hidden="true"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Amount</span>
                        <span class="info-box-number">৳ {{ number_format($vendor_total_purchase_amount, 2) }}<small> BDT</small></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-usd" aria-hidden="true"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Paid Amount</span>
                        <span class="info-box-number">৳ {{ number_format($vendor_total_purchase_paid_amount, 2) }}<small> BDT</small></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-usd" aria-hidden="true"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Due Amount</span>
                        <span class="info-box-number">৳ {{ number_format($vendor_total_purchase_due_amount, 2) }}<small> BDT</small></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <h4>CUSTOMER DETAILS</h4>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Name: </strong>{{ $vendor->name }}</td>
                    <td><strong>Address: </strong>{{ $vendor->address }}</td>
                    <td><strong>Contact Number: </strong>{{ $vendor->contact_no }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <h4>CUSTOMER'S ALL PURCHASES</h4>
            <table id="po-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>SL#</th>
                                <th>PO NO#(By System)</th>
                                <th>PCH NO#(Manual Entry)</th>
                                <th>Purchase Date</th>
                                <th>Amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vendor->PurchaseOrders as $k => $purchase_order)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td><a href="{{ route('purchase-order',['company_id' => Request::segment(2),'id' => $purchase_order->id]) }}">{{ $purchase_order->id }}</a></td>
                                    <td><a href="{{ route('purchase-order',['company_id' => Request::segment(2),'id' => $purchase_order->id]) }}">{{ $purchase_order->challan_no_mannual }}</a></td>
                                    <td>{{ $purchase_order->purchase_date }}</td>
                                    <td>{{ number_format($purchase_order->amount, 2) }}</td>
                                    <td>{{ number_format($purchase_order->paid_amount, 2) }}</td>
                                    <td>{{ number_format($purchase_order->due_amount, 2) }}</td>
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
            $('#po-table').DataTable({
                "order": [[ 3, "desc" ]]
            })
        });
    </script>
@endsection

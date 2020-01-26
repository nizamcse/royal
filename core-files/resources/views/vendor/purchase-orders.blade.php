@extends('layouts.vendor')

@section('content')
    <div class="box box-info" style="padding-top: 15px;background-color: transparent; box-shadow: none">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">CPU Traffic</span>
                        <span class="info-box-number">90<small>%</small></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Likes</span>
                        <span class="info-box-number">41,410</span>
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
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Sales</span>
                        <span class="info-box-number">760</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">New Members</span>
                        <span class="info-box-number">2,000</span>
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
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Purchase Orders</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Payments</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Log Summary</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table id="po-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>PO NO</th>
                                <th>CH NO</th>
                                <th>Vendor</th>
                                <th>Amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
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
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">

                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">

                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        Date.prototype.getMonthWeek = function(){
            var firstDay = new Date(this.getFullYear(), this.getMonth(), 1).getDay();
            return Math.ceil((this.getDate() + firstDay)/7);
        }

       console.log(new Date().addDay());
        $(document).ready(function () {
            //$('#po-table').DataTable()
        });
    </script>
@endsection

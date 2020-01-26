@extends('layouts.app')
@section('style')
    <style>
        .panel {
            border-radius: 0px!important;
        }
        .panel-primary {
            border:0px;
            background:#A2001C!important;
        }
        .panel-primary .panel-heading {
            border:0px;
            background:#A2001C!important;
            color:#fff;
            min-height:100px;
        }
        .panel-violet {
            border:0px;
            background: #7800A2!important;
            color:#fff!important;
        }
        .panel-violet .panel-heading {
            border:0px;
            background: #7800A2!important;
            color:#fff;
            min-height:100px;
        }
        .panel-green {
             border:0px;
             background: #3BA200!important;
             color:#fff!important;
         }
        .panel-green .panel-heading {
            border:0px;
            background: #3BA200!important;
            color:#fff;
            min-height:100px;
        }
        .panel-gray {
            border:0px;
            background: #105D07!important;
            color:#fff!important;
        }
        .panel-gray .panel-heading {
            border:0px;
            background: #105D07!important;
            color:#fff;
            min-height:100px;
        }
        .btn {
            border-radius: 0px!important;
            background: transparent;
            color: #0e0e0e;
            border-top: 0;
            border-right: 0;
            border-left: 0;

            font-size: 20px;
        }
        .btn-info {
            border-bottom: 1px solid #A2001C!important;
        }
        .btn-info:hover {
            border:0px;
            background:#A2001C!important;
        }
        .btn-info:focus {
            border:0px;
            color: #fff;
            background-color: #A2001C!important;
            border-color: #A2001C!important;
        }
        .btn-info:active {
            color: #fff;
            background-color: #A2001C!important;
            border-color: #A2001C!important;
        }
        .btn-violet {
            border-bottom: 1px solid #7800A2!important;
        }
        .btn-violet:hover {
            border:0px;
            background:#7800A2!important;
        }
        .btn-violet:focus {
            border:0px;
            color: #fff;
            background-color: #7800A2!important;
            border-color: #7800A2!important;
        }
        .btn-violet:active {
            color: #fff;
            background-color: #7800A2!important;
            border-color: #7800A2!important;
        }
        .btn-green {
            border-bottom: 1px solid #3BA200!important;
        }
        .btn-green:hover {
            border:0px;
            background:#3BA200!important;
        }
        .btn-green:focus {
            border:0px;
            color: #fff;
            background-color: #3BA200!important;
            border-color: #3BA200!important;
        }
        .btn-green:active {
            color: #fff;
            background-color: #3BA200!important;
            border-color: #3BA200!important;
        }
        .btn-gray {
            border-bottom: 1px solid #105D07!important;
        }
        .btn-gray:hover {
            border:0px;
            background:#105D07!important;
        }
        .btn-gray:focus {
            border:0px;
            color: #fff;
            background-color: #105D07!important;
            border-color: #105D07!important;
        }
        .btn-gray:active {
            color: #fff;
            background-color: #105D07!important;
            border-color: #105D07!important;
        }
        .list-group-item:first-child {
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
        }
        .badge {
            color:#000000;
            background: transparent;
            font-weight: bold;
        }
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">COmpany Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>

                            <!-- Purchase Overview-->
                            <h3>Purchase Overview</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="panel panel-violet">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Today Amount</h2>
                                            <h3>{{ $today_purchase_overview[0]->current_day ? '৳ '.number_format((float)$today_purchase_overview[0]->current_day, 2, '.', '') : '৳ 0.00'}} BDT</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-violet">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Yesterday</h2>
                                            <h3>{{ $yestarday_purchase_overview[0]->yesterday_overview ? '৳ '.number_format((float)$yestarday_purchase_overview[0]->yesterday_overview, 2, '.', '') : '৳ 0.00'}} BDT</h3>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-violet">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Current: {{ date('F', mktime(0, 0, 0, $last_month, 10)) }} {{ $last_year }}</h2>
                                            <h3>{{ $current_month_purchase_overview[0]->current_month ? '৳ '.number_format((float)$current_month_purchase_overview[0]->current_month, 2, '.', '') : '৳ 0.00'}} BDT</h3>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-violet btn-block" data-toggle="collapse" data-target="#demo2">Recent Purchase Order</button>
                                    <div id="demo2" class="collapse">
                                        <ul class="list-group">
                                            @foreach($purches_overviews as $k=>$purches_overview)
                                                @if( $k < 6 )
                                                    <li class="list-group-item">{{ $purches_overview->purchase_date  }}<span class="badge">{{ $purches_overview->amount ? '৳ '.number_format((float)$purches_overview->amount, 2, '.', ''): '৳ 0.00'}} BDT</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-violet btn-block" data-toggle="collapse" data-target="#demo3">Last Six Month Parches Amount</button>
                                    <div id="demo3" class="collapse">
                                        <ul class="list-group">
                                            @foreach($month_parches_overview as $k=>$overview)
                                                @if( $k < 6)
                                                    <li class="list-group-item">{{ date("F", mktime(0, 0, 0, $overview->reference_month, 10))  }}<span class="badge">{{ $overview->monthly_amount ? '৳'. number_format((float)$overview->monthly_amount, 2, '.', '') : '৳ 0.00'}} BDT</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Purchase payment -->
                            <h3>Purchase Payment Overview</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Today Amount</h2>
                                            <h3>{{ $today_parches_amounts[0]->current_day ? '৳ '.number_format((float)$today_parches_amounts[0]->current_day, 2, '.', '') : '৳ 0.00'}} BDT</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Yesterday</h2>
                                            <h3>{{ $yestarday_purchase_amounts[0]->current_day ? '৳ '.number_format((float)$yestarday_purchase_amounts[0]->current_day, 2, '.', '' ) : '৳ 0.00'}} BDT</h3>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Current: {{ date('F', mktime(0, 0, 0, $last_month, 10)) }} {{ $last_year }}</h2>
                                            <h3>{{ $current_month_parches_amounts[0]->current_month ? '৳ '.number_format((float)$current_month_parches_amounts[0]->current_month, 2, '.', '') : '৳ 0.00'}} BDT</h3>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-info btn-block" data-toggle="collapse" data-target="#demo0">Recent Purchase Order</button>
                                    <div id="demo0" class="collapse">
                                        <ul class="list-group">
                                        @foreach($recent_purchases as $k=>$purchase)
                                             @if( $k < 6 )
                                                <li class="list-group-item">{{ $purchase->payment_date  }}<span class="badge">{{ $purchase->amount ? '৳ '.number_format((float)$purchase->amount, 2, '.', '') : '৳ 0.00' }} BDT</span></li>
                                              @endif
                                        @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-info btn-block" data-toggle="collapse" data-target="#demo">Last Six Month Parches Amount</button>
                                    <div id="demo" class="collapse">
                                        <ul class="list-group">
                                            @foreach($monthly_parches_amount_query as $k=>$monthly_purchase)
                                                @if( $k < 6)
                                                    <li class="list-group-item">{{ date("F", mktime(0, 0, 0, $monthly_purchase->reference_month, 10))  }}<span class="badge">{{ $monthly_purchase->monthly_payments ? '৳ '.number_format((float)$monthly_purchase->monthly_payments, 2, '.', '') : '৳ 0.00' }} BDT</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Sales overview Start -->
                            <h3>Sales Overview</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="panel panel-green">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Today</h2>
                                            <br>
                                            <h4><strong>Total Amount: </strong>{{ $today_sales_overview[0]->total ? '৳ '.number_format((float)$today_sales_overview[0]->total, 2, '.', '') : '৳ 0.00'}} BDT</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-green">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Yesterday</h2>
                                            <br>
                                            <h4><strong>Total Amount: </strong>{{ $yestarday_sales_overview[0]->total ? '৳ '.number_format((float)$yestarday_sales_overview[0]->total, 2, '.', '') : '৳ 0.00'}} BDT</h4>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-green">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Current: {{ date('F', mktime(0, 0, 0, $last_month, 10)) }} {{ $last_year }}</h2>
                                            <br>
                                            <h4><strong>Total Amount: </strong>{{ $current_month_sales_overview[0]->total ? '৳ '.number_format((float)$current_month_sales_overview[0]->total, 2, '.', '') : '৳ 0.00'}} BDT</h4>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-green btn-block" data-toggle="collapse" data-target="#demo7">Recent Sales Overview</button>
                                    <div id="demo7" class="collapse">
                                        <ul class="list-group">
                                            @foreach($sales_overviews as $k=>$sales_overview)
                                                @if( $k < 6 )
                                                    <li class="list-group-item">{{ $sales_overview->sold_out_date  }}<span class="badge">{{ $sales_overview->total_amount ? '৳ '.number_format((float)$sales_overview->total_amount, 2, '.', '') : '৳ 0.00' }} BDT</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-green btn-block" data-toggle="collapse" data-target="#demo6">Last Six Month Sales Overview</button>
                                    <div id="demo6" class="collapse">
                                        <ul class="list-group">
                                            @foreach($monthly_sales_overviews as $k=>$monthly_sales_overviews)
                                                @if( $k < 6)
                                                    <li class="list-group-item">{{ date("F", mktime(0, 0, 0, $monthly_sales_overviews->month, 10))  }}<span class="badge">{{ $monthly_sales_overviews->monthly_total ? '৳ '.number_format((float)$monthly_sales_overviews->monthly_total, 2, '.', '') : '৳ 0.00' }} BDT</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Sales Payments Start -->
                            <h3>Sales Payments</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="panel panel-gray">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Today</h2>
                                            <h4><strong>Total Amount: </strong>{{ $today_sales_payment[0]->total ? '৳ '.number_format((float)$today_sales_payment[0]->total, 2, '.', '') : '৳ 0.00'}} BDT</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-gray">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Yesterday</h2>
                                            <h4><strong>Total Amount: </strong>{{ $yestarday_sales_payment[0]->total ? '৳ '.number_format((float)$yestarday_sales_payment[0]->total, 2, '.', '') : '৳ 0.00'}} BDT</h4>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-gray">
                                        <div class="panel-heading text-center">
                                            <h2 class="panel-title">Current: {{ date('F', mktime(0, 0, 0, $last_month, 10)) }} {{ $last_year }}</h2>
                                            <h4><strong>Total Amount: </strong>{{ $current_month_sales_payment[0]->total ? '৳ '.number_format((float)$current_month_sales_payment[0]->total, 2, '.', '') : '৳ 0.00'}} BDT</h4>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-gray btn-block" data-toggle="collapse" data-target="#demo8">Recent Sales Payments</button>
                                    <div id="demo8" class="collapse">
                                        <ul class="list-group">
                                            @foreach($sales_payments as $k=>$sales_payment)
                                                @if( $k < 6 )
                                                    <li class="list-group-item">{{ $sales_payment->payment_date  }}<span class="badge">{{ $sales_payment->amount ? '৳ '.number_format((float)$sales_payment->amount, 2, '.', '') : '৳ 0.00' }} BDT</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-gray btn-block" data-toggle="collapse" data-target="#demo9">Last Six Month Sales Payments</button>
                                    <div id="demo9" class="collapse">
                                        <ul class="list-group">
                                            @foreach($monthly_sales_payments as $k=>$monthly_sales_payment)
                                                @if( $k < 6)
                                                    <li class="list-group-item">{{ date("F", mktime(0, 0, 0, $monthly_sales_payment->month, 10))  }}<span class="badge">{{ $monthly_sales_payment->monthly_total ? '৳ '.number_format((float)$monthly_sales_payment->monthly_total, 2, '.', '') : '৳ 0.00' }} BDT</span></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "Purchases and Sales Comparision."
            },
            legend:{
                cursor: "pointer",
                verticalAlign: "center",
                horizontalAlign: "right",
                itemclick: toggleDataSeries
            },
            data: [{
                type: "column",
                name: "Sales",
                indexLabel: "{y}",
                yValueFormatString: "$#0.##",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },{
                type: "column",
                name: "purchases",
                indexLabel: "{y}",
                yValueFormatString: "$#0.##",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            }
            else{
                e.dataSeries.visible = true;
            }
            chart.render();
        }

    }
</script>

@endsection

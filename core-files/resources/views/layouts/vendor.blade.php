<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="base-url" content="{{ url('/') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Royal') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/bower_components/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/tags-input/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/tags-input/bootstrap-tagsinput-typeahead.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
@yield('style')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="app" class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>N</b>Royal Admin Panel</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Royal Admin Panel</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Purchase Orders</a>
                    </li>
                    <li>
                        <a href="#">Purchase Summary</a>
                    </li>
                    <li>
                        <a href="#">Payment History</a>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{--<img src="{{ asset('frontend/images/logo.png') }}" class="user-image" alt="User Image">--}}
                            <span class="hidden-xs">{{ Auth::user() ? Auth::user()->name : '' }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                {{--<img src="{{ asset('frontend/images/logo.png') }}" class="img-circle" alt="User Image">--}}

                                <p>
                                    {{ Auth::user() ? Auth::user()->email : '' }}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">

                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i> <span>Home</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('companies') }}">
                        <i class="fa fa-home"></i> <span>Companies</span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-database"></i>
                        <span>Master Data</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('units',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Unit</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('raw-materials',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Raw Material</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-industry"></i>
                        <span>Inventory</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('inventory.raw-materials',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Raw Material
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('inventory.other-materials',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Other Material
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('inventory.production-products',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Ready For Sale Goods
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-plus"></i>
                        <span>Hr</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('designations',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Designations</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('leave-types',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Leave Type</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employees',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Employees</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('attendances',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Attendances</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Purchase</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('categories',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Categories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('grades',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Grade
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vendors',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Vendor
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('purchase-orders',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Purchase Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('create-purchase-order',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> Create Purchase Order
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-product-hunt"></i>
                        <span>Productions</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('goods',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Goods</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('create-production',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> Create Production
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('productions',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> Productions
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('production-inventory-goods',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> Produced Goods
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Sales</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('sales-orders',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Sales Orders</a></li>
                        <li><a href="{{ route('create-sales-order',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Create Sales Orders</a></li>
                        <li><a href="{{ route('chalans',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Chalans</a></li>
                        <li><a href="{{ route('return-chalans',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Return Chalans</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span>Accounts</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('payment-types',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Payment Types</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('sales-payments',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Sales Payment</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('purchase-payments',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Purchase Payment</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('expense-heads',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Expense Head</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('expenses',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Expense</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('accounts',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Account</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('journals',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Journal Entries</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('create-journal',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>New Journal Entry</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('transactions',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Transactions</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('trial-balance',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Trial Balance</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('transactions',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Income Statement</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2018 <a href="javascript:void(0)">Nizam</a>.</strong> All rights
        reserved.
    </footer>

    <div class="modal fade in" id="delete-content-modal" tabindex="-1" role="dialog" aria-labelledby="delete-content-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <h3>Do you want to delete this content.</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                    <a href="#" id="delete-modal-btn" class="btn btn-danger">YES</a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('admin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('admin/bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('admin/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('admin/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('admin/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- Slimscroll -->
<!-- Datatable -->
<script src="{{ asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="{{ asset('admin/plugins/tags-input/bootstrap-tagsinput.min.js') }}"></script>
@yield('script')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click','.btn-delete',function(){
            var url = $(this).data('url');
            $("#delete-modal-btn").attr('href',url);
        });
    });

</script>
</body>

</html>

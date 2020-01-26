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
            <span class="logo-mini"><b>{{ \App\Model\Company::find(Request::segment(2))->name }}</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ \App\Model\Company::find(Request::segment(2))->name }}</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
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
                @if(Auth::user()->can('users-show',Request::segment(2)) || Auth::user()->can('roles-show',Request::segment(2)))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-lock"></i>
                        <span>Authorization</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('permissions-show', Request::segment(2))
                            <li>
                                <a href="{{ route('permissions',['company_id' => Request::segment(2)]) }}">
                                    <i class="fa fa-circle-o"></i> <span>Permissions</span>
                                </a>
                            </li>
                        @endcan
                        @can('roles-show', Request::segment(2))
                        <li>
                            <a href="{{ route('roles',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Roles</span>
                            </a>
                        </li>
                        @endcan
                        @can('users-show', Request::segment(2))
                        <li>
                            <a href="{{ route('users',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Users</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if(Auth::user()->can('units-show',Request::segment(2)) || Auth::user()->can('raw-materials-show',Request::segment(2)))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-database"></i>
                        <span>Master Data</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('units-show',Request::segment(2))
                        <li>
                            <a href="{{ route('units',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Unit</span>
                            </a>
                        </li>
                        @endcan
                        @can('raw-materials-show',Request::segment(2))
                            <li>
                                <a href="{{ route('raw-materials',['company_id' => Request::segment(2)]) }}">
                                    <i class="fa fa-circle-o"></i> <span>Raw Material</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if(Auth::user()->can('inventory-raw-materials-show',Request::segment(2)) || Auth::user()->can('inventory-other-materials-show',Request::segment(2))
                 || Auth::user()->can('inventory-logs-materials-show',Request::segment(2)) || Auth::user()->can('inventory-ready-for-sale-goods-show',Request::segment(2)))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-industry"></i>
                        <span>Inventory</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('inventory-raw-materials-show',Request::segment(2))
                        <li>
                            <a href="{{ route('inventory.raw-materials',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Raw Material
                            </a>
                        </li>
                        @endcan

                        @can('inventory-other-materials-show',Request::segment(2))
                        <li>
                            <a href="{{ route('inventory.other-materials',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Other Material
                            </a>
                        </li>
                        @endcan
                        @can('inventory-logs-materials-show',Request::segment(2))
                        <li>
                            <a href="{{ route('inventory.logs',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Logs
                            </a>
                        </li>
                        @endcan
                        @can('inventory-ready-for-sale-goods-show',Request::segment(2))
                        <li>
                            <a href="{{ route('inventory.production-products',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i>Ready For Sale Goods
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if(Auth::user()->can('designations-show',Request::segment(2)) || Auth::user()->can('leave-types-show',Request::segment(2)) ||
                    Auth::user()->can('employees-show',Request::segment(2)) || Auth::user()->can('attendances-show',Request::segment(2)) ||
                    Auth::user()->can('bonus-types-show',Request::segment(2)) || Auth::user()->can('deduction-types-show',Request::segment(2)) ||  Auth::user()->can('salary-create',Request::segment(2)) ||
                    Auth::user()->can('vacations-show',Request::segment(2)) || Auth::user()->can('employee-leaves-show',Request::segment(2)) || Auth::user()->can('employee-salaries-show',Request::segment(2)))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-plus"></i>
                        <span>Hr</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('designations-show',Request::segment(2))
                        <li>
                            <a href="{{ route('designations',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Designations</span>
                            </a>
                        </li>
                        @endcan
                        @can('leave-types-show',Request::segment(2))
                        <li>
                            <a href="{{ route('leave-types',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Leave Type</span>
                            </a>
                        </li>
                        @endcan
                        @can('employees-show',Request::segment(2))
                        <li>
                            <a href="{{ route('employees',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Employees</span>
                            </a>
                        </li>
                        @endcan
                        @can('attendances-show',Request::segment(2))
                        <li>
                            <a href="{{ route('attendances',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Attendances</span>
                            </a>
                        </li>
                        @endcan
                        @can('bonus-types-show',Request::segment(2))
                        <li>
                            <a href="{{ route('bonuses',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Bonus Types</span>
                            </a>
                        </li>
                        @endcan
                        @can('deduction-types-show',Request::segment(2))
                        <li>
                            <a href="{{ route('deduction-types',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Deduction Types</span>
                            </a>
                        </li>
                        @endcan
                        @can('vacations-show',Request::segment(2))
                        <li>
                            <a href="{{ route('vacations',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Vacations</span>
                            </a>
                        </li>
                        @endcan
                        @can('employee-leaves-show',Request::segment(2))
                        <li>
                            <a href="{{ route('leaves',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Employee Leaves</span>
                            </a>
                        </li>
                        @endcan
                        @can('salaries-create',Request::segment(2))
                        <li>
                            <a href="{{ route('create-salary',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Create Salary</span>
                            </a>
                        </li>
                        @endcan
                        @can('employee-salaries-show',Request::segment(2))
                        <li>
                            <a href="{{ route('employee-salaries',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Salaries</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if(Auth::user()->can('vendors-show',Request::segment(2)))
                    @can('vendors-show',Request::segment(2))
                        <li>
                            <a href="{{ route('vendors',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-address-book"></i>Vendor List
                            </a>
                        </li>
                    @endcan
                @endif
                @if(Auth::user()->can('categories-show',Request::segment(2)) || Auth::user()->can('grades-show',Request::segment(2)) ||
                Auth::user()->can('log-purchase-order-create',Request::segment(2)) || Auth::user()->can('log-purchase-order-show',Request::segment(2)))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Log Purchase</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                        <ul class="treeview-menu">
                            @can('categories-show',Request::segment(2))
                                <li>
                                    <a href="{{ route('categories',['company_id' => Request::segment(2)]) }}">
                                        <i class="fa fa-circle-o"></i>Categories
                                    </a>
                                </li>
                            @endif
                            @can('grades-show',Request::segment(2))
                                <li>
                                    <a href="{{ route('grades',['company_id' => Request::segment(2)]) }}">
                                        <i class="fa fa-circle-o"></i>Grade
                                    </a>
                                </li>
                            @endcan
                            @can('log-purchase-order-show',Request::segment(2))
                                <li>
                                    <a href="{{ route('logPurchaseOrders.index',['company_id' => Request::segment(2)]) }}">
                                        <i class="fa fa-circle-o"></i>All Orders
                                    </a>
                                </li>
                            @endcan
                            @can('log-purchase-order-create',Request::segment(2))
                            <li>
                                <a href="{{ route('logPurchaseOrders.create',['company_id' => Request::segment(2)]) }}">
                                    <i class="fa fa-circle-o"></i>Create
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logPurchaseOrders.drafts',['company_id' => Request::segment(2)]) }}">
                                    <i class="fa fa-circle-o"></i>Drafts
                                </a>
                            </li>
                            @endcan
                        </ul>

                </li>
                @endif


                @if(Auth::user()->can('material-purchase-order-create',Request::segment(2)) || Auth::user()->can('material-purchase-orders-show',Request::segment(2)))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-shopping-cart"></i>
                            <span>Material Purchase</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>

                        <ul class="treeview-menu">
                            @can('material-purchase-orders-show',Request::segment(2))
                                <li>
                                    <a href="{{ route('materialPurchaseOrders.index',['company_id' => Request::segment(2)]) }}">
                                        <i class="fa fa-circle-o"></i>All Orders
                                    </a>
                                </li>
                            @endcan
                            @can('material-purchase-order-create',Request::segment(2))
                                <li>
                                    <a href="{{ route('materialPurchaseOrders.create',['company_id' => Request::segment(2)]) }}">
                                        <i class="fa fa-circle-o"></i>Create
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('materialPurchaseOrders.drafts',['company_id' => Request::segment(2)]) }}">
                                        <i class="fa fa-circle-o"></i>Drafts
                                    </a>
                                </li>
                            @endcan
                        </ul>

                    </li>
                @endif



{{--                @if(Auth::user()->can('categories-show',Request::segment(2)) || Auth::user()->can('grades-show',Request::segment(2))--}}
{{--                || Auth::user()->can('purchase-orders-show',Request::segment(2)) || Auth::user()->can('purchase-order-create',Request::segment(2)))--}}
{{--                <li class="treeview">--}}
{{--                    <a href="#">--}}
{{--                        <i class="fa fa-shopping-cart"></i>--}}
{{--                        <span>Purchase</span>--}}
{{--                        <span class="pull-right-container">--}}
{{--                            <i class="fa fa-angle-left pull-right"></i>--}}
{{--                        </span>--}}
{{--                    </a>--}}
{{--                    <ul class="treeview-menu">--}}

{{--                        @can('purchase-orders-show',Request::segment(2))--}}
{{--                        <li>--}}
{{--                            <a href="{{ route('purchase-orders',['company_id' => Request::segment(2)]) }}">--}}
{{--                                <i class="fa fa-circle-o"></i> <span>Purchase Orders</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        @endcan--}}

{{--                        @can('purchase-order-create',Request::segment(2))--}}
{{--                        <li>--}}
{{--                            <a href="{{ route('create-purchase-order',['company_id' => Request::segment(2)]) }}">--}}
{{--                                <i class="fa fa-circle-o"></i> Create Purchase Order--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        @endcan--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                @endif--}}

                @if(
                Auth::user()->can('goods-show',Request::segment(2)) || Auth::user()->can('production-create',Request::segment(2))
                || Auth::user()->can('productions-show',Request::segment(2)) || Auth::user()->can('produced-goods-show',Request::segment(2))
                )
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-product-hunt"></i>
                        <span>Productions</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('goods-show',Request::segment(2))
                        <li>
                            <a href="{{ route('goods',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Goods</span>
                            </a>
                        </li>
                        @endcan
                        @can('production-create',Request::segment(2))
                            <li>
                            <a href="{{ route('create-production',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> Create Production
                            </a>
                        </li>
                        @endcan
                        @can('productions-show',Request::segment(2))
                        <li>
                            <a href="{{ route('productions',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> Productions
                            </a>
                        </li>
                        @endcan
                        @can('produced-goods-show',Request::segment(2))
                        <li>
                            <a href="{{ route('production-inventory-goods',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> Produced Goods
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if(Auth::user()->can('customers-show',Request::segment(2)))
                    @can('customers-show',Request::segment(2))
                    <li>
                        <a href="{{ route('customers.index',['company_id' => Request::segment(2)]) }}">
                            <i class="fa fa-address-book"></i>Customers List
                        </a>
                    </li>
                    @endcan
                @endif
                @if(Auth::user()->can('sales-orders-show',Request::segment(2)) || Auth::user()->can('sales-order-create',Request::segment(2))
                || Auth::user()->can('sales-chalans-show',Request::segment(2)) || Auth::user()->can('sales-return-chalans-show',Request::segment(2)))

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Sales</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('sales-orders-show',Request::segment(2))
                            <li><a href="{{ route('sales-orders',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Sales Orders</a></li>
                        @endcan
                        @can('sales-order-create',Request::segment(2))
                            <li><a href="{{ route('create-sales-order',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Create Sales Orders</a></li>
                        @endcan
                        @can('sales-chalans-show',Request::segment(2))
                            <li><a href="{{ route('chalans',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Chalans</a></li>
                        @endcan
                        @can('sales-return-chalans-show',Request::segment(2))
                            <li><a href="{{ route('return-chalans',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Return Chalans</a></li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if(Auth::user()->can('purchase-sales-return-chalans-show',Request::segment(2)) || Auth::user()->can('purchase-sales-chalans-show',Request::segment(2)) ||
                Auth::user()->can('purchase-sales-order-create',Request::segment(2)) || Auth::user()->can('purchase-sales-orders-show',Request::segment(2)))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cart-plus"></i>
                        <span>Purchase Sales</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('purchase-sales-orders-show',Request::segment(2))
                        <li><a href="{{ route('purchase-sales-orders',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Sales Orders</a></li>
                        @endcan
                        @can('purchase-sales-order-create',Request::segment(2))
                            <li><a href="{{ route('create-purchase-sales-order',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Create Sales Orders</a></li>
                        @endcan
                        @can('purchase-sales-chalans-show',Request::segment(2))
                            <li><a href="{{ route('purchase-sales-chalans',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Chalans</a></li>
                        @endcan
                        @can('purchase-sales-return-chalans-show',Request::segment(2))
                            <li><a href="{{ route('purchase-sales-return-chalans',['company_id' => Request::segment(2)]) }}"><i class="fa fa-circle-o"></i>Return Chalans</a></li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if(
                Auth::user()->can('payment-types-show',Request::segment(2)) || Auth::user()->can('sales-payments-show',Request::segment(2)) || Auth::user()->can('purchase-payments-show',Request::segment(2)) ||
                Auth::user()->can('expense-heads-show',Request::segment(2)) || Auth::user()->can('expenses-show',Request::segment(2)) || Auth::user()->can('accounts-show',Request::segment(2)) ||
                Auth::user()->can('journal-entries-show',Request::segment(2)) || Auth::user()->can('journal-create',Request::segment(2)) || Auth::user()->can('transactions-show',Request::segment(2)) ||
                Auth::user()->can('trial-balance-show',Request::segment(2)) || Auth::user()->can('account-statements-show',Request::segment(2))
                )
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span>Accounts</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('accounts-setting-show',Request::segment(2))
                            <li>
                                <a href="{{ route('account-setting',['company_id' => Request::segment(2)]) }}">
                                    <i class="fa fa-circle-o"></i> <span>Accounts Settings</span>
                                </a>
                            </li>
                        @endcan
                        @can('payment-types-show',Request::segment(2))
                        <li>
                            <a href="{{ route('payment-types',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Payment Types</span>
                            </a>
                        </li>
                        @endcan
                        @can('sales-payments-show',Request::segment(2))
                        <li>
                            <a href="{{ route('sales-payments',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Sales Payment</span>
                            </a>
                        </li>
                        @endcan
                        @can('purchase-payments-show',Request::segment(2))
                        <li>
                            <a href="{{ route('purchase-payments',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Purchase Payment</span>
                            </a>
                        </li>
                        @endcan
                        @can('expense-heads-show',Request::segment(2))
                        <li>
                            <a href="{{ route('expense-heads',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Expense Head</span>
                            </a>
                        </li>
                        @endcan
                        @can('expenses-show',Request::segment(2))
                        <li>
                            <a href="{{ route('expenses',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Expense</span>
                            </a>
                        </li>
                        @endcan
                        @can('accounts-show',Request::segment(2))
                        <li>
                            <a href="{{ route('accounts',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Account</span>
                            </a>
                        </li>
                        @endcan
                        @can('journal-entries-show',Request::segment(2))
                        <li>
                            <a href="{{ route('journals',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Journal Entries</span>
                            </a>
                        </li>
                        @endcan
                        @can('journal-create',Request::segment(2))
                        <li>
                            <a href="{{ route('create-journal',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>New Journal Entry</span>
                            </a>
                        </li>
                        @endcan
                        @can('transactions-show',Request::segment(2))
                        <li>
                            <a href="{{ route('transactions',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Transactions</span>
                            </a>
                        </li>
                        @endcan
                        @can('trial-balance-show',Request::segment(2))
                        <li>
                            <a href="{{ route('trial-balance',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Trial Balance</span>
                            </a>
                        </li>
                        @endcan
                        @can('account-statements-show',Request::segment(2))
                        <li>
                            <a href="{{ route('account-statements',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-circle-o"></i> <span>Account Statement</span>
                            </a>
                        </li>
                        @endcan
                        <li>
                            <a href="#">
                                <i class="fa fa-circle-o"></i> <span>Income Statement</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('account-closings',['company_id' => Request::segment(2)]) }}">
                                <i class="fa fa-close"></i> <span>Accounts Closing</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->can('summary-types-show',Request::segment(2)) || Auth::user()->can('summaries-show', Request::segment(2)))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-money"></i>
                            <span>Account Summary</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('summary-types-show',Request::segment(2))
                                <li>
                                    <a href="{{ route('summary-types',['company_id' => Request::segment(2)]) }}">
                                        <i class="fa fa-circle-o"></i> <span>Summary Type</span>
                                    </a>
                                </li>
                            @endcan
                            @can('summaries-show',Request::segment(2))
                                <li>
                                    <a href="{{ route('summaries',['company_id' => Request::segment(2)]) }}">
                                        <i class="fa fa-circle-o"></i> <span>Summaries</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->can('show-sales-orders-report',Request::segment(2)))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text" aria-hidden="true"></i>
                            <span>Reports</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('show-sales-orders-report',Request::segment(2))
                            <li>
                                <a href="{{ route('reports.getSalesOrdersReport', ['company_id' => Request::segment(2)]) }}">
                                    <i class="fa fa-circle-o"></i> <span>Sales Orders</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endif
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
        <strong>Copyright &copy; 2018 <a href="https://winskit.com/">Winskit Int</a>.</strong> All rights
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

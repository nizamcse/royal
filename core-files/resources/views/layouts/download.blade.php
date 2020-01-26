<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            font-size: 12px;
            font-weight: normal;
        }
        .box-header{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            border-bottom: 5px solid #EAB543;
        }
        .box-footer{
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            border-top: 5px solid #EAB543;
        }
        .box-body{
            margin-top: 100px;
            margin-bottom: 100px;
        }
        .table{
            width: 100%;
            max-width: 100%;
            border: 1px solid #f4f4f4;
            border-spacing: 0;
            border-collapse: collapse;
            font-family: 'Hind Siliguri', sans-serif;
        }
        .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            font-size: 8px;
        }
        .table>tbody>tr>td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: middle;
            font-size: 8px;
        }
        .table>thead>tr>th {
            vertical-align: bottom;
            border-bottom: 2px solid #ddd;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 1px solid #f4f4f4;
        }
        .table-bordered>thead>tr>th, .table-bordered>thead>tr>td {
            border-bottom-width: 2px;
        }
        .table>thead:first-child>tr:first-child>th {
            border-top: 0;
        }
        .text-theme{
            color: #EAB543;
        }
        .mb-30{
            margin-bottom: 30px;
        }
        .text-right{
            text-align: right;
        }
        .border-none{
            border: 0px !important;
        }
        .text-center{
            text-align: center;
        }
        .text-uppercase{
            text-transform: uppercase;
        }
        .text-right{
            text-align: right;
        }
    </style>
    @yield('style')
</head>
<body>
<div class="box">
    <div class="box-header">
        <h2 class="text-theme" style="text-transform: uppercase">{{ $company->name }}</h2>
    </div>
    @yield('content')
    <div class="box-footer"></div>
</div>
</body>
</html>
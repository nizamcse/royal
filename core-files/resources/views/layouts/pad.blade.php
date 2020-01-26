<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            margin: 0px;
            margin-top: 70px;
            margin-bottom: 100px;
        }
        body{
            font-size: 12px;
            font-weight: normal;
        }
        header {
            position: fixed;
            top: -70px;
            left: 0px;
            right: 0px;
            background-color: #ffc27a;
            height:70px;
            line-height: 1.2;
            border-bottom: 2px solid #EEEEEE;
            padding: 10px 0;
        }
        footer {
            position: fixed;
            bottom: -100px;
            left: 0px;
            right: 0px;
            background-color: #FFF;
            height: 78px;
            line-height: 1.2;
            border-top: 2px solid #EEEEEE;
            padding: 10px 0;
        }

        .body-text{
            padding: 30px;
        }
        table{
            width: 100%;
            margin:0;
            padding: 0;
        }
        .w-50{
            width: 50%;
        }
        .text-right{
            text-align: right;
        }
        .header-table{
            width: 100%;
            height: 70px;
            color: #7D8080;
            font-size: 16px;
            padding-left: 30px;
            padding-right: 30px;
        }
        .header-table > tbody > tr > td{
            vertical-align: middle;
        }
        .header-table > tbody > tr > td:last-child {

        }
        .header-table > tbody > tr > td > span{
            display: inline-block;
            margin-right: 10px;
        }
        .header-table > tbody > tr > td p{
            margin:0;
            padding: 0;
            line-height: 1;
        }
        .header-table > tbody > tr > td .header-icon{
            display: inline-block;
            width: 16px;
            height: 16px;
            vertical-align: middle;
            margin-right: 10px;
        }
        .header-table > tbody > tr > td > .contact-title{
            color: #333;
            margin:0;
            padding: 7px 0;
        }
        .header-table > tbody > tr > td > .invoice-title{
            font-size: 24px;
            color: #333;
            text-align: right;
            display: block;
            line-height: 1;
        }


        .footer-table{
            width: 100%;
            height: 100%;
            color: #7D8080;
            font-size: 16px;
            padding-left: 30px;
            padding-right: 30px;
        }
        .footer-table > tbody > tr > td{
            text-align: center;
            border-right: 1px solid #EEEEEE;
            width: 25%;
            font-size: 12px;
            vertical-align: middle;
        }
        .footer-table > tbody > tr > td:last-child {
            border-right: 0px;
        }
        .footer-table > tbody > tr > td > span{
            display: block;
        }
        .footer-table > tbody > tr > td .footer-icon{
            display: inline-block;
            width: 24px;
            height: 24px;
            vertical-align: middle;
        }
        .footer-table > tbody > tr > td .footer-logo{
            height: 40px;
        }
        .page-break{
            page-break-after: always;
        }
        .header-logo{
            max-height: 40px;
            width: auto;
        }

        .box-body .table > thead > tr > th,
        .box-body .table > thead > tr > td{
            background-color: #fafafa;
            padding: 7px;
        }
        .box-body .table > tbody > .odd{
            background-color: #fafafa;
        }
        .w-100px{
            width: 100px;
        }
        .w-200px{
            width: 200px;
        }
        .w-100{
            width: 100%;
        }
        .text-center{
            text-align: center;
        }
        th.vertical-text {
            /* Something you can count on */
            height: 140px !important;
            white-space: nowrap;
        }
        th.vertical-text > span {
            transform: rotate(-90deg);
        }



    </style>
</head>
<body>
<header>
    <table class="header-table">
        <tbody>
        <tr>
            <td>
                <img src="{{ asset($company->logo) }}" alt="TRIMATRIK" class="header-logo">
            </td>
            <td class="text-right company-name"><span class="invoice-title">{{ $company->name }}</span></td>
        </tr>
        </tbody>
    </table>
</header>
<footer>
    <table class="footer-table">
        <tbody>
        <tr>
            <td>
                <strong>{{ $company->address }}</strong>
            </td>
        </tbody>
    </table>
</footer>

<div class="body-text">
    @yield('content')
</div>
</body>
</html>
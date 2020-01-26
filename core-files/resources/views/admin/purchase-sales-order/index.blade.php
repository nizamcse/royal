@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF PURCHASE SALES ORDER
                <a href="{{ route('create-purchase-sales-order',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </a>
                <a  class="btn btn-sm pull-right btn-warning flat">
                    <i class="fa fa-download"></i> DOWNLOAD
                </a>

            </h3>
        </div>
        {{--table lists--}}
        <purchase-sales-order :items="{ PurchaseSalesOrder:'{{ route('purchase-sales-orders',['company_id' => Request::segment(2)]) }}', GetPurchaseSalesOrder:'{{ route('get-purchase-sales-orders',['company_id' => Request::segment(2)]) }}', DownloadPurchaseSalesOrder:'{{  route('download-purchase-sales-order',['company_id' => Request::segment(2),'id' => '']) }}', ShowPurchaseSalesOrder:'{{  route('show-purchase-sales-order',['company_id' => Request::segment(2),'id' => '']) }}'}"></purchase-sales-order>
        {{--table lists--}}

    </div>
@endsection

@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
    <script type="text/javascript">
        // $(document).ready(function () {
        //     $('#sales-orders').DataTable(
        //         {
        //             "order": [[2, "desc"]]
        //         }
        //     )
        // });
    </script>
@endsection

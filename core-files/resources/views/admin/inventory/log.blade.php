@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LOG INVENTORY
            </h3>
        </div>
        <div class="box-body">
            <table id="logs" class="table table-bordered list-table">
                <thead>
                <tr>
                    <th>SL#</th>
                    <th>CHALAN NO</th>
                    <th class="text-right">TOTAL QTY</th>
                    <th class="text-right">USED QTY</th>
                    <th class="text-right">WASTED QTY</th>
                    <th class="text-right">REMAINING QTY</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchase_orders as $k => $purchase_order)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $purchase_order->challan_no_mannual }}</td>
                        <td class="text-right">{{ $purchase_order->logs ? $purchase_order->logs->sum('quantity') : '' }}</td>
                        <td class="text-right">{{ $purchase_order->logs ? $purchase_order->logs->sum('new_quantity') : '' }}</td>
                        <td class="text-right">{{ $purchase_order->logs ? $purchase_order->logs->sum('wastage_quantity') : '' }}</td>
                        <td class="text-right">
                            @php
                                if($purchase_order->logs){
                                    $rem_qty = $purchase_order->logs->sum('quantity') - $purchase_order->logs->sum('new_quantity') - $purchase_order->logs->sum('wastage_quantity');
                                    echo number_format($rem_qty,2);
                                }
                            @endphp
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
            $("#log").dataTable();
        });
    </script>
@endsection

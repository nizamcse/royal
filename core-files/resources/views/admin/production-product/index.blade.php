@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF PRODUCTION PRODUCT AND STOCK
            </h3>
        </div>
        <div class="box-body">
            <table id="goods-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Thickness</th>
                    <th>Size</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($production_products as $k => $production_product)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $production_product->good ? $production_product->good->name : '' }}</td>
                        <td>{{ $production_product->good ? $production_product->good->unit ? $production_product->good->unit->name : '' : '' }}</td>
                        <td>{{ $production_product->good ? $production_product->good->thickness : '' }}</td>
                        <td>{{ $production_product->good ? $production_product->good->size : '' }}</td>
                        <td>{{ $production_product->quantity }}</td>
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

        });
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                INVENTORY PRODUCTION GOODS
            </h3>
        </div>
        <div class="box-body">
            <table id="production-goods" class="table table-bordered list-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Thickness</th>
                    <th>Size</th>
                    <th class="w-100 text-right">Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($production_goods as $production_good)
                    <tr>
                        <td>{{ $production_good->good ? $production_good->good->name : '' }}</td>
                        <td>{{ $production_good->good ? $production_good->good->unit ? $production_good->good->unit->name : '' : '' }}</td>
                        <td>{{ $production_good->good ? $production_good->good->thickness : '' }}</td>
                        <td>{{ $production_good->good ? $production_good->good->size : '' }}</td>
                        <td class="text-right">{{ $production_good->quantity }}</td>
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
            $("#production-goods").dataTable({
                responsive: true
            });
        });
    </script>
@endsection

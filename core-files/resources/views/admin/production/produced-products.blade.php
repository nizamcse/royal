@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                PRODUCTION INVENTORY GOODS
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
                @foreach($produced_goods as $produced_good)
                    <tr>
                        <td>{{ $produced_good->first() ?  $produced_good->first()->good ? $produced_good->first()->good->name : '' : '' }}</td>
                        <td>{{ $produced_good->first() ?  $produced_good->first()->good ? $produced_good->first()->good->unit_name : '' : '' }}</td>
                        <td>{{ $produced_good->first() ?  $produced_good->first()->good ? $produced_good->first()->good->thickness : '' : '' }}</td>
                        <td>{{ $produced_good->first() ?  $produced_good->first()->good ? $produced_good->first()->good->size : '' : '' }}</td>
                        <td>{{ $produced_good->sum_of_remaining_quantity }}</td>
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
            $("#production-goods").dataTable();
        });
    </script>
@endsection

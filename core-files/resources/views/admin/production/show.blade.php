@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>PRODUCTION SUMMARY</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <p>START AT</p>
                    <span>{{ $production->start_at }}</span>
                </div>
                <div class="col-md-3">
                    <p>END AT</p>
                    <span>{{ $production->end_at }}</span>
                </div>
                <div class="col-md-2">
                    <p>GOOD PRODUCED</p>
                    <span>{{ $production->good_produced ? 'YES' : 'NO' }}</span>
                </div>
                <div class="col-md-2">
                    <p>GOOD VALUE</p>
                    <span>{{ $production->producedGoods ? $production->producedGoods->sum('produced_goods_value') : 0 }}</span>
                </div>
                <div class="col-md-2">
                    <p>PRODUCTION COST</p>
                    <span>{{ $production->total_production_cost }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h4>
                LIST OF PRODUCED GOODS
                <a href="{{ route('release-production-product',['company_id' => Request::segment(2),'id' => $production]) }}" class="btn btn-sm btn-info pull-right">RELEASE</a>
            </h4>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Goods Name</th>
                    <th>Produced Quantity</th>
                    <th>Released Quantity</th>
                    <th>Remaining Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($production->producedGoods as $producedGood)
                    <tr>
                        <td>{{ $producedGood->good ? $producedGood->good->name : '' }}</td>
                        <td>{{ $producedGood->produced_quantity }}</td>
                        <td>{{ $producedGood->released_quantity }}</td>
                        <td>{{ $producedGood->remaining_quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h4>LIST OF PRODUCED GOODS RELEASING</h4>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Goods Name</th>
                    <th>Created At</th>
                    <th>Released Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($release_goods as $producedGood)
                    <tr>
                        <td>{{ $producedGood->good ? $producedGood->good->name : '' }}</td>
                        <td>{{ $producedGood->created_at }}</td>
                        <td>{{ $producedGood->quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

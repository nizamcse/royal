@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF PRODUCTIONS
                <a href="{{ route('create-production',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </a>
            </h3>
        </div>
        <div class="box-body">
            <table id="production-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>START AT</th>
                    <th>END AT</th>
                    <th>PRODUCTION HOUR</th>
                    <th>GOOD PRODUCED</th>
                    <th>GOODS VALUE</th>
                    <th>TOTAL COST</th>
                    <th>STATUS</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productions as $k => $production)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $production->start_at }}</td>
                        <td>{{ $production->end_at }}</td>
                        <td>{{ $production->production_hour }}</td>
                        <td>{{ $production->good_produced ? 'YES' : 'NO' }}</td>
                        <span>{{ $production->producedGoods ? $production->producedGoods->sum('produced_goods_value') : 0 }}</span>
                        <td>{{ $production->total_production_cost }}</td>
                        <td>{!! $production->status ? '<span class="text-success">COMPLETE</span>' : '<span class="text-danger">INCOMPLETE</span>' !!}</td>
                        <td class="text-right">
                            <a href="{{ route('create-production-product',['company_id' => Request::segment(2),'id' => $production->id]) }}" class="btn btn-sm btn-success">CREATE PRODUCTION PRODUCT</a>
                            <a href="{{ route('show-production',['company_id' => Request::segment(2),'id' => $production->id]) }}" class="btn btn-info btn-sm">VIEW</a>
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
            $('#production-table').DataTable()
        });
    </script>
@endsection

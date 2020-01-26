@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                INVENTORY RAW MATERIALS
            </h3>
        </div>
        <div class="box-body">
            <table id="raw-materials" class="table table-bordered list-table">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th class="w-100 text-right">Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($raw_materials as $raw_material)
                    <tr>
                        <td>{{ $raw_material->materialName() }}</td>
                        <td>{{ $raw_material->unitName() }}</td>
                        <td class="text-right">{{ $raw_material->quantity }}</td>
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
            $("#raw-materials").dataTable();
        });
    </script>
@endsection

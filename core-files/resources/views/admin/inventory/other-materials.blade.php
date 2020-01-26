@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                INVENTORY OTHER MATERIALS
            </h3>
        </div>
        <div class="box-body">
            <table id="other-materials" class="table table-bordered list-table">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Thickness</th>
                    <th>Size</th>
                    <th>Unit</th>
                    <th class="w-100 text-right">Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($other_materials as $other_material)
                    <tr>
                        <td>{{ $other_material->materialName() }}</td>
                        <td>{{ $other_material->thickness }}</td>
                        <td>{{ $other_material->size }}</td>
                        <td>{{ $other_material->unitName() }}</td>
                        <td class="text-right">{{ $other_material->quantity }}</td>
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
            $("#other-material").dataTable();
        });
    </script>
@endsection

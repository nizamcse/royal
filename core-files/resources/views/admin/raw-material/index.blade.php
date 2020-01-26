@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF RAW MATERIALS
                @can('raw-material-create')
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#raw_material-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
                @endcan
            </h3>
        </div>
        <div class="box-body">
            <table id="raw-materials-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($raw_materials as $k => $raw_material)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $raw_material->name }}</td>
                        <td>{{ $raw_material->unit ? $raw_material->unit->name : '' }}</td>
                        <td class="text-right">
                            @can('raw-material-edit')
                                <button data-id="{{ $raw_material->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-raw_material"><i class="fa fa-edit" ></i>Edit</button>
                            @endcan

                            @can('raw-material-delete')
                                <button data-url="{{ route('delete-raw-material',['company_id' => Request::segment(2),'id' => $raw_material->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @can('raw-material-create')
    <div class="modal fade in" id="raw_material-modal" tabindex="-1" role="dialog" aria-labelledby="raw_material">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('create-raw-material',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE RAW MATERIAL</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Raw Material Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Unit *</label>
                            <select name="unit_id" class="form-control" required>
                                <option value="">Select Unit</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-flat">CREATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    @can('raw-material-edit')
    <div class="modal fade in" id="edit-raw_material" tabindex="-1" role="dialog" aria-labelledby="edit-raw_material">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-raw_material-form" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE RAW MATERIAL</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="control-label">Raw Material Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Unit *</label>
                                <select name="unit_id" class="form-control" required>
                                    <option value="">Select Unit</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-flat">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            var url = "{{ route('raw-material',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-raw_material-form").attr('action',api_url);
                        $("#edit-raw_material-form input[name='name']").val(result.name);
                        $("#edit-raw_material-form select[name='unit_id']").val(result.unit_id);
                    }});
            });

            $('#raw-materials-table').DataTable()
        });
    </script>
@endsection

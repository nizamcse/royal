@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF GOODS
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#good-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
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
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($goods as $k => $good)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $good->name }}</td>
                        <td>{{ $good->thickness }}</td>
                        <td>{{ $good->size }}</td>
                        <td>{{ $good->unit ? $good->unit->name : '' }}</td>
                        <td>{{ $good->price }}</td>
                        <td class="text-right">
                            <button data-id="{{ $good->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-good"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-good',['company_id' => Request::segment(2),'id' => $good->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade in" id="good-modal" tabindex="-1" role="dialog" aria-labelledby="good">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('create-good',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE GOOD</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Thickness </label>
                            <input type="text" class="form-control" name="thickness">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Size </label>
                            <input type="text" class="form-control" name="size">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Price </label>
                            <input type="text" class="form-control" name="price" required>
                        </div>
                        <div class="form-group">
                            <label>Unit</label>
                            <select name="unit_id" class="form-control">
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
    <div class="modal fade in" id="edit-good" tabindex="-1" role="dialog" aria-labelledby="edit-good">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-good-form" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE GOOD</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label">Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Thickness </label>
                                <input type="text" class="form-control" name="thickness">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Size </label>
                                <input type="text" class="form-control" name="size">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Price </label>
                                <input type="text" class="form-control" name="price" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Unit </label>
                                <select name="unit_id" class="form-control">
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

            var url = "{{ route('good',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-good-form").attr('action',api_url);
                        $("#edit-good-form input[name='name']").val(result.name);
                        $("#edit-good-form input[name='price']").val(result.price);
                        $("#edit-good-form input[name='thickness']").val(result.thickness);
                        $("#edit-good-form input[name='size']").val(result.size);
                        $("#edit-good-form select[name='unit_id']").val(result.unit_id);
                    }});
            });

            $('#goods-table').DataTable()
        });
    </script>
@endsection

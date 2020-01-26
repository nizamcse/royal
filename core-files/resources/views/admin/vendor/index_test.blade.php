@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF VENDORS
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#vendor-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label name="product_type" for="exampleFormControlSelect1">Product Type</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option disabled selected>Please Select</option>
                        <option value="1">Log</option>
                        <option value="2">Row Material</option>
                        <option value="3">Other Material</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="raw-material-id">Raw Material</label>
                    <input name="raw_material_id" type="email" class="form-control" id="raw-material-id" placeholder="" readonly>
                </div>
            </div>
            <table id="vendors-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Contact No</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($vendors as $k => $vendor)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td><a href="{{ route('vendor-profile',['company_id' => Request::segment(2),'id' => $vendor->id]) }}">{{ $vendor->name }}</a></td>
                        <td>{{ $vendor->contact_no }}</td>
                        <td>{{ $vendor->address }}</td>
                        <td class="text-right">
                            <button data-id="{{ $vendor->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-vendor"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-vendor',['company_id' => Request::segment(2),'id' => $vendor->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                        {{ $vendors->links() }}
        </div>
    </div>
    <div class="modal fade in" id="vendor-modal" tabindex="-1" role="dialog" aria-labelledby="vendor">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('create-vendor',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE VENDOR</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Contact No *</label>
                            <input type="text" class="form-control" name="contact_no" required>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Address</label>
                            <input type="text" class="form-control" name="address" required>
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
    <div class="modal fade in" id="edit-vendor" tabindex="-1" role="dialog" aria-labelledby="edit-vendor">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-vendor-form" method="post">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE VENDOR</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="control-label">Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Contact No *</label>
                                <input type="text" class="form-control" name="contact_no" required>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Address</label>
                                <input type="text" class="form-control" name="address" required>
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

            var url = "{{ route('vendor',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-vendor-form").attr('action',api_url);
                        $("#edit-vendor-form input[name='name']").val(result.name);
                        $("#edit-vendor-form input[name='contact_no']").val(result.contact_no);
                        $("#edit-vendor-form input[name='address']").val(result.address);
                    }});
            });

            // $('#vendors-table').DataTable()
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF CUSTOMERS
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#customer-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
        </div>
        <div class="box-body">
            @include('layouts.partials.message')
            <table id="customers-table" class="table table-bordered table-striped">
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
                @foreach($customers as $k => $customer)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>
                            <a href="{{ route('customers.show',['company_id' => Request::segment(2),'id' => $customer->id]) }}">
                                {{ $customer->name }}
                            </a>
                        </td>
                        <td>{{ $customer->contact_no }}</td>
                        <td>{{ $customer->address }}</td>
                        <td class="text-right">
                            <button data-id="{{ $customer->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-customer"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-id="{{ $customer->id }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-customer"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

{{--    ---------------------------------- create modal -------------------------------}}
    <div class="modal fade in" id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="customer">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('customers.store',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE CUSTOMER</h4>
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

{{--    ------------------------ update modal ----------------------------}}
    <div class="modal fade in" id="edit-customer" tabindex="-1" role="dialog" aria-labelledby="edit-customer">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-customer-form" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE CUSTOMER</h4>
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

{{--        ------------------------ delete modal ----------------------------}}
    <div class="modal fade in" id="delete-customer" tabindex="-1" role="dialog" aria-labelledby="delete-content-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <h3>Do you want to delete this content.</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="" id="delete-customer-form" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                        <button type="submit" id="delete-modal-btn" class="btn btn-danger">YES</button>
                    </form>
                </div>
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


            $(document).on('click','.btn-edit',function () {
                const getCustomerUrl = "{{ route('customers.getJsonCustomer',['company_id' => Request::segment(2),'id' => '']) }}/";
                const customerUpdateUrl = "{{ route('customers.update',['company_id' => Request::segment(2),'id' => '']) }}/";
                let id = $(this).data('id');
                let getCustomerRoute = getCustomerUrl +id;
                let customerUpdateRoute = customerUpdateUrl + id;
                $.ajax({url: getCustomerRoute, success: function(result){
                    console.log(result);
                        $("#edit-customer-form").attr('action',customerUpdateRoute);
                        $("#edit-customer-form input[name='name']").val(result.name);
                        $("#edit-customer-form input[name='contact_no']").val(result.contact_no);
                        $("#edit-customer-form input[name='address']").val(result.address);
                    }});
            });

            $(document).on('click', '.btn-delete', function () {
                const customerDeleteUrl = "{{ route('customers.destroy',['company_id' => Request::segment(2),'id' => '']) }}/";
                let id = $(this).data('id');
                let customerDeleteRoute = customerDeleteUrl + id;
                $("#delete-customer-form").attr('action',customerDeleteRoute);
            });

            $('#customers-table').DataTable()
        });
    </script>
@endsection

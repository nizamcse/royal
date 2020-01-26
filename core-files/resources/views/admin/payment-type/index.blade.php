@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF PAYMENT TYPES
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#payment-type-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
        </div>
        <div class="box-body">
            <table id="payment-types-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payment_types as $k => $payment_type)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $payment_type->name }}</td>
                        <td class="text-right">
                            <a href="{{ route('payment-type-field',['company_id' => Request::segment(2),'id' => $payment_type->id]) }}" class="btn btn-xs btn-success">View Extra Filed</a>
                            <button data-id="{{ $payment_type->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-payment-type"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-payment-type',['company_id' => Request::segment(2),'id' => $payment_type->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade in" id="payment-type-modal" tabindex="-1" role="dialog" aria-labelledby="payment-type">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('create-payment-type',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE PAYMENT TYPE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Name *</label>
                            <input type="text" class="form-control" name="name" required>
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
    <div class="modal fade in" id="edit-payment-type" tabindex="-1" role="dialog" aria-labelledby="edit-payment-type">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-payment-type-form" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE PAYMENT TYPE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="control-label">Name *</label>
                                <input type="text" class="form-control" name="name" required>
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

            var url = "{{ route('payment-type',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-payment-type-form").attr('action',api_url);
                        $("#edit-payment-type-form input[name='name']").val(result.name);
                    }});
            });

            $('#payment-types-table').DataTable()
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF FIELDS FOR PAYMENT TYPE - {{ $payment_type->name }}
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
                    <th>Input Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payment_type->fields as $k => $field)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $field->name }}</td>
                        <td>{{ $field->date_type ? 'DATE INPUT' : 'TEXT' }}</td>
                        <td class="text-right">
                            <button data-id="{{ $field->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-payment-type"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-payment-type-field',['company_id' => Request::segment(2),'id' => $field->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
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
                <form action="{{ route('create-payment-type-field',['company_id' => Request::segment(2),'id' => $payment_type->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE FIELD</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <div class="checkbox icheck" style="padding-left:15px">
                                <label>
                                    <input type="checkbox" name="date_type">  For date input.
                                </label>
                            </div>
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
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE FIELD</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <div class="checkbox icheck" style="padding-left:15px">
                                <label>
                                    <input type="checkbox" name="date_type">  For date input.
                                </label>
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

            var url = "{{ route('payment-type-field',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-payment-type-form").attr('action',api_url);
                        $("#edit-payment-type-form input[name='name']").val(result.name);
                        if(result.date_type)
                            $("#edit-payment-type-form input[name='date_type']").attr("checked",true);
                    }});
            });

            $('#payment-types-table').DataTable()
        });
    </script>
@endsection

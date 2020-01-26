@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF DEDUCTION TYPE
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#deduction-type-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
        </div>
        <div class="box-body">
            <table id="deduction-typees-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deduction_types as $k => $deduction_type)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $deduction_type->name }}</td>
                        <td class="text-right">
                            <button data-id="{{ $deduction_type->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-deduction-type"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-deduction-type',['company_id' => Request::segment(2),'id' => $deduction_type->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade in" id="deduction-type-modal" tabindex="-1" role="dialog" aria-labelledby="deduction-type">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('create-deduction-type',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE DEDUCTION TYPE</h4>
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
    <div class="modal fade in" id="edit-deduction-type" tabindex="-1" role="dialog" aria-labelledby="edit-deduction-type">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-deduction-type-form" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE DEDUCTION TYPE</h4>
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

            var url = "{{ route('deduction-type',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-deduction-type-form").attr('action',api_url);
                        $("#edit-deduction-type-form input[name='name']").val(result.name);
                    }});
            });

            $('#deduction-typees-table').DataTable()
        });
    </script>
@endsection

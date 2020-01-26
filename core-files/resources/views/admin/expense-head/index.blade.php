@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF EXPENSE HEADS
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#expense-head-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
        </div>
        <div class="box-body">
            @include('mag')
            <table id="expense-heads-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($expense_heads as $k => $expense_head)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $expense_head->name }}</td>
                        <td class="text-right">
                            <button data-id="{{ $expense_head->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-expense-head"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-expense-head',['company_id' => Request::segment(2),'id' => $expense_head->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade in" id="expense-head-modal" tabindex="-1" role="dialog" aria-labelledby="expense-head">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('create-expense-head',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE EXPENSE HEAD</h4>
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
    <div class="modal fade in" id="edit-expense-head" tabindex="-1" role="dialog" aria-labelledby="edit-expense-head">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-expense-head-form" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE EXPENSE HEAD</h4>
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

            var url = "{{ route('expense-head',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-expense-head-form").attr('action',api_url);
                        $("#edit-expense-head-form input[name='name']").val(result.name);
                    }});
            });

            $('#expense-heads-table').DataTable()
        });
    </script>
@endsection

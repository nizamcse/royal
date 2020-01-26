@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF EXPENSES
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#expense-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
        </div>
        <div class="box-body">
            <table id="expenses-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>DATE</th>
                    <th>Expense Head</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($expenses as $k => $expense)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $expense->expense_date }}</td>
                        <td>{{ $expense->head ? $expense->head->name : '' }}</td>
                        <td>{{ $expense->amount }}</td>
                        <td class="text-right">
                            <button data-id="{{ $expense->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-expense"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-expense',['company_id' => Request::segment(2),'id' => $expense->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade in" id="expense-modal" tabindex="-1" role="dialog" aria-labelledby="expense">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('create-expense',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE EXPENSE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Expense Head</label>
                            <select name="expense_head_id" class="form-control">
                                <option value="">Select Expense Head</option>
                                @foreach($expense_heads as $expense_head)
                                    <option value="{{ $expense_head->id }}">{{ $expense_head->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" name="expense_date" class="form-control datepicker" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea name="comment" cols="30" rows="5" class="form-control"></textarea>
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
    <div class="modal fade in" id="edit-expense" tabindex="-1" role="dialog" aria-labelledby="edit-expense">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-expense-form" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE EXPENSE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Expense Head</label>
                                <select name="expense_head_id" class="form-control">
                                    <option value="">Select Expense Head</option>
                                    @foreach($expense_heads as $expense_head)
                                        <option value="{{ $expense_head->id }}">{{ $expense_head->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" name="expense_date" class="form-control datepicker" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" name="amount" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea name="comment" cols="30" rows="5" class="form-control"></textarea>
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

            var url = "{{ route('expense',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-expense-form").attr('action',api_url);
                        $("#edit-expense-form textarea[name='comment']").val(result.comment);
                        $("#edit-expense-form input[name='amount']").val(result.amount);
                        $("#edit-expense-form input[name='expense_date']").val(result.expense_date);
                        $("#edit-expense-form select[name='expense_head_id']").val(result.expense_head_id);
                    }});
            });

            $('#expenses-table').DataTable()

            $(".datepicker").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                startDate: new Date(),
            });
        });
    </script>
@endsection



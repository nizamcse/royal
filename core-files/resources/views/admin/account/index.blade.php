@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF ACCOUNTS
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#account-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
        </div>
        <div class="box-body">
            <table id="accounts-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $k => $account)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td><a href="{{ route('show-ledger',['company_id' => Request::segment(2),'id' => $account->id]) }}">{{ $account->name }}</a></td>
                        <td>{{ Config::get('enums.account_types')[$account->type] ?? "" }}</td>
                        <td class="text-right">
                            <button data-id="{{ $account->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-account"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-account',['company_id' => Request::segment(2),'id' => $account->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade in" id="account-modal" tabindex="-1" role="dialog" aria-labelledby="account">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('create-account',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE ACCOUNT</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Account Type</label>
                            <select name="type" class="form-control" required>
                                <option value="">Select Account Type</option>
                                @foreach(Config::get('enums.account_types') as $k => $account_type)
                                    <option value="{{ $k }}">{{ $account_type }}</option>
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
    <div class="modal fade in" id="edit-account" tabindex="-1" role="dialog" aria-labelledby="edit-account">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-account-form" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE ACCOUNT</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="control-label">Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <select name="type" class="form-control" required>
                                    <option value="">Select Account Type</option>
                                    @foreach(Config::get('enums.account_types') as $k => $account_type)
                                        <option value="{{ $k }}">{{ $account_type }}</option>
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

            var url = "{{ route('account',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-account-form").attr('action',api_url);
                        $("#edit-account-form input[name='name']").val(result.name);
                        $("#edit-account-form select[name='type']").val(result.type);
                    }});
            });

            $('#accounts-table').DataTable()
        });
    </script>
@endsection

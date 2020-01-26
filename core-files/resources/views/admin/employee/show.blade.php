@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Employee Details <a href="{{ route('employees',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-info pull-right">Employee List</a></h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name : </strong>{{ $employee->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Company Name : </strong>{{ $employee->company_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Contact No : </strong>{{ $employee->contact_no }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Nid No : </strong>{{ $employee->nid }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Present Address : </strong>{{ $employee->present_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Permanent Address : </strong>{{ $employee->permanent_address }}</p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>Email : </strong>{{ $employee->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>In Time : </strong>{{ \Carbon\Carbon::parse($employee->in_time)->format('g:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Exit Time : </strong>{{ \Carbon\Carbon::parse($employee->exit_time)->format('g:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Salary : </strong>{{ $employee->salary }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Salary Type : </strong>{{ $employee->salary_base }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <figure class="user-image">
                        <img src="{{ asset($employee->photo) }}" class="img-responsive" alt="">
                    </figure>
                </div>
            </div>
        </div>
        <!-- /.panel-body -->
    </div>
    <div class="box">
        <div class="box-header"><h4>DATE WISE ROSTER</h4> <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#roster-modal">
                <i class="fa fa-plus-circle"></i> CREATE NEW
            </button></div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>In Time</th>
                    <th>Exit Time</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee->rosters as $roster)
                    <tr>
                        <td>{{ $roster->roster_date }}</td>
                        <td>{{ $roster->shift ? 'Day' : 'Night' }}</td>
                        <td>{{ \Carbon\Carbon::parse($roster->in_time)->format('g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($roster->exit_time)->format('g:i A') }}</td>
                        <td>{{ $roster->description }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="box">
        <div class="box-header"><h4>ALLOWED LEAVE TYPE</h4> <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#employee-leave-type-modal">
                <i class="fa fa-plus-circle"></i> CREATE NEW
            </button></div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Leave Type</th>
                    <th>Max Allowed Days</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee->leaveTypes as $leaveType)
                    <tr>
                        <td>{{ $leaveType->name }}</td>
                        <td>{{ $leaveType->pivot->max_allowed_days }}</td>
                        <td class="text-right">
                            <button data-id="{{ $leaveType->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-employee-leave-type"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-employee-leave-type',['company_id' => Request::segment(2),'id' => $leaveType->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade in" id="roster-modal" tabindex="-1" role="dialog" aria-labelledby="roster">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('create-roster',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE ROSTER</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="control-label">Date *</label>
                                    <input type="text" class="form-control datepicker" name="roster_date" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>In Time</label>
                                    <date-time :inputs="{format: 'HH:mm',name: 'in_time' }"></date-time>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exit Time</label>
                                    <date-time :inputs="{format: 'HH:mm',name: 'exit_time' }"></date-time>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <select name="shift" class="form-control">
                                        <option value="0">Day</option>
                                        <option value="2">Night</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Minimum Working Hour</label>
                                    <input type="text" name="minimum_working_hour" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>Job Details</label>
                                <textarea name="job_details" cols="30" rows="4" class="form-control"></textarea>
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

    <div class="modal fade in" id="employee-leave-type-modal" tabindex="-1" role="dialog" aria-labelledby="employee-leave-type">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('store-employee-leave-type',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE LEAVE TYPE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Leave Type *</label>
                            <select name="leave_type_id" class="form-control" required>
                                <option value="">Select Leave Type</option>
                                @foreach($leave_types as $leave_type)
                                    <option value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Max Allowed Days</label>
                            <input type="number" class="form-control" name="max_allowed_days" required>
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

    <div class="modal fade in" id="edit-employee-leave-type" tabindex="-1" role="dialog" aria-labelledby="edit-employee-leave-type">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-employee-leave-type-form" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE LEAVE TYPE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Leave Type *</label>
                            <select name="leave_type_id" class="form-control" required>
                                <option value="">Select Leave Type</option>
                                @foreach($leave_types as $leave_type)
                                    <option value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Max Allowed Days</label>
                            <input type="number" class="form-control" name="max_allowed_days" required>
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


@section('styles')
@endsection


@section('script')
    <script src="{{ asset('core-files/public/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).ready(function () {
                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
            $(".datepicker").datepicker({});
            var url = "{{ route('employee-leave-type',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-employee-leave-type-form").attr('action',api_url);
                        $("#edit-employee-leave-type-form select[name='leave_type_id']").val(result.leave_type_id);
                        $("#edit-employee-leave-type-form input[name='max_allowed_days']").val(result.max_allowed_days);
                    }});
            });
        });
    </script>
@endsection

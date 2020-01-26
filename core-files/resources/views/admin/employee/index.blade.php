@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3>List Of Employee <a href="{{ route('create-employee',['company_id' => Request::segment(2)]) }}" class="btn btn-sm btn-info pull-right">Create New</a></h3>
                </div>
                <!-- /.panel-heading -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Contact No</th>
                                <th>Present Address</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $k => $employee)
                                <tr class="{{ $k % 2 == 0 ? 'even gradeC' : 'odd gradeX' }}">
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $employee->id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->contact_no }}</td>
                                    <td>{{ $employee->present_address }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('show-employee',['company_id' => Request::segment(2),'id' => $employee->id]) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('edit-employee',['company_id' => Request::segment(2),'id' => $employee->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <button class="btn btn-sm btn-danger btn-delete" data-url="{{ route('delete-employee',['company_id' => Request::segment(2),'id' => $employee->id]) }}" data-toggle="modal" data-target="#deleteModal">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection


@section('styles')
    <!-- DataTables CSS -->
    <link href="{{ asset('admin/vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="test.css">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('admin/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
@endsection


@section('scripts')
    <script src="{{ asset('admin/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(document).on('click','.btn-delete',function(){
                var url = $(this).data('url');
                $("#deleting-url").attr("href",url);

            });

            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
@endsection

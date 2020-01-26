@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3>
                        List Of Companies
                        @if(Auth::user()->super_admin)
                            <a href="{{ route('create-company') }}" class="btn btn-sm btn-info pull-right">Create New</a>
                        @endif
                    </h3>
                </div>
                <!-- /.panel-heading -->
                <div class="box-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-companies">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Contact No</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $k => $company)
                            <tr class="{{ $k % 2 == 0 ? 'even gradeC' : 'odd gradeX' }}">
                                <td>{{ $k+1 }}</td>
                                <td>
                                    @if($company->logo)
                                        <img src="{{ asset($company->logo) }}" alt="" class="img-responsive" style="max-height: 50px">
                                    @endif
                                </td>
                                <td><a href="{{ route('company-dashboard',['company_id' => $company->id]) }}">{{ $company->name }}</a></td>
                                <td>{{ $company->contact_no }}</td>
                                <td>{{ $company->address }}</td>
                                <td class="text-right">
                                    <a href="{{ route('show-company',['id' => $company->id]) }}" class="btn btn-sm btn-info">View</a>
                                    @if(Auth::user()->super_admin || Auth::user()->can('edit-company',$company->id))
                                        <a href="{{ route('edit-company',['id' => $company->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <button class="btn btn-sm btn-danger btn-delete" data-url="{{ route('delete-company',['id' => $company->id]) }}" data-toggle="modal" data-target="#deleteModal">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
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

            $('#dataTables-companies').DataTable({
                responsive: true
            });
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                SOFTWARE ROLE LIST
                @can('create-roles',Request::segment(2))
                    <a href="{{ route('create-role',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                        <i class="fa fa-plus-circle"></i> CREATE ROLE
                    </a>
                @endcan
            </h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Role Name</th>
                        <th class="text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td class="text-right" style="vertical-align: middle">
                                @can('edit-roles',Request::segment(2))
                                    <a href="{{ route('show-role',['company_id' => Request::segment(2),'id' => $role->id]) }}" class="btn btn-xs btn-info flat"><i class="fa fa-eye"></i> View</a>
                                @endcan
                                @can('edit-roles',Request::segment(2))
                                    <a href="{{ route('edit-role',['company_id' => Request::segment(2),'id' => $role->id]) }}" class="btn btn-warning btn-xs btn-flat">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                @endcan

                                @can('delete-roles',Request::segment(2))
                                    <button data-url="{{ route('delete-role',['company_id' => Request::segment(2),'id' => $role->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection

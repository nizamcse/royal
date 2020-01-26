@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h4>
                SOFTWARE USERS LIST
                <a href="{{ route('create-user',['company_id' => Request::segment(2)]) }}" class="btn btn-sm pull-right btn-info">
                    <i class="fa fa-plus-circle"></i> CREATE USER
                </a>
            </h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->companyRole(Request::segment(2)) }}</td>
                            <td class="text-right">
                                @can('user-edit')
                                    <a href="{{ route('edit-user',['company_id' => Request::segment(2),'id' => $user->id]) }}" class="btn btn-xs btn-warning flat"><i class="fa fa-pencil"></i> Edit</a>
                                @endcan
                                @can('user-delete')
                                    <button data-url="{{ route('delete-user',['company_id' => Request::segment(2),'id' => $user->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i> Delete</button>
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

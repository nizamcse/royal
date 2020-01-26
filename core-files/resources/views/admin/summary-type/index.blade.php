@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF SUMMARY TYPE
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#Summary-type-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
            @include('msg')
        </div>
        <div class="box-body">
            <table id="summary-type-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($summary_types as $k => $summary_type)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $summary_type->name }}</td>
                        <td class="text-right">
                            <button data-id="{{ $summary_type->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-summary-type"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-id="{{ $summary_type->id }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-summary-type"><i class="fa fa-trash-o"></i>Delete</button>
                            {{--<button data-url="" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                   
            </table>
        </div>
    </div>
    <!------------------------------ Create Model ---------------------------->
    <div class="modal fade in" id="Summary-type-modal" tabindex="-1" role="dialog" aria-labelledby="summary-type">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('summary-types.create',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE SUMMARY TYPE</h4>
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
    <!----------------unpdat Summary Type -------------------------->
    <div class="modal fade in" id="edit-summary-type" tabindex="-1" role="dialog" aria-labelledby="edit-summary-type">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-summary-type-form" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE SUMMARY TYPE</h4>
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
    <!------------------------destroy summer type ------------------------------>
    <div class="modal fade in" id="delete-summary-type" tabindex="-1" role="dialog" aria-labelledby="delete-content-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <h3>Do you want to delete this content.</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="" id="delete-summary-type-form" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                        <button type="submit" id="delete-modal-btn" class="btn btn-danger">YES</button>
                    </form>
                </div>
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

            $(document).on('click','.btn-edit', function(){
               const summaryTypeUpdateUrl = "{{ route('summary-types.edit',['company_id' => Request::segment(2), 'id' => ''] ) }}/";
               let id = $(this).data('id');
               let summaryTypeUpdateRoute = summaryTypeUpdateUrl + id;
                $.ajax({url: summaryTypeUpdateRoute, success: function(result){
                        $("#edit-summary-type-form").attr('action',summaryTypeUpdateRoute);
                        $("#edit-summary-type-form input[name='name']").val(result.name);
                    }});
            });

            $(document).on('click', '.btn-delete', function () {
                const summaryTypeDeleteUrl = "{{ route('summary-types.destroy', ['company_id' => Request::segment(2), 'id' => '']) }}/";
                let id = $(this).data('id');
                let summeryTypeDeleteRoute = summaryTypeDeleteUrl+id;
                $("#delete-summary-type-form").attr('action', summeryTypeDeleteRoute);
                $("")
            });


            $('#summary-type-table').DataTable()
        });
    </script>
@endsection

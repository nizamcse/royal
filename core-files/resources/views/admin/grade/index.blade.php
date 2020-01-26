@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                LIST OF GRADES
                <button type="button" class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#grade-modal">
                    <i class="fa fa-plus-circle"></i> CREATE NEW
                </button>
            </h3>
        </div>
        <div class="box-body">
            <table id="grades-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Category</th>
                    <th>Grade Name</th>
                    <th>Min Radius</th>
                    <th>Max Radius</th>
                    <th>Unite Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($grades as $k => $grade)
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $grade->category ? $grade->category->name : '' }}</td>
                        <td>{{ $grade->name }}</td>
                        <td>{{ $grade->min_radius }}</td>
                        <td>{{ $grade->max_radius }}</td>
                        <td>{{ $grade->price_per_unit }}</td>
                        <td class="text-right">
                            <button data-id="{{ $grade->id }}" class="btn btn-warning btn-xs flat btn-edit" data-toggle="modal" data-target="#edit-grade"><i class="fa fa-edit" ></i>Edit</button>
                            <button data-url="{{ route('delete-grade',['company_id' => Request::segment(2),'id' => $grade->id]) }}" class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal"><i class="fa fa-trash-o"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade in" id="grade-modal" tabindex="-1" role="dialog" aria-labelledby="grade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('create-grade',['company_id' => Request::segment(2)]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">CREATE GRADE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <select name="category_id" class="form-control">
                            <option>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label for="name" class="control-label">Minimun Radius</label>
                            <input type="text" class="form-control" name="min_radius">
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Maximum Radius</label>
                            <input type="text" class="form-control" name="max_radius">
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Unite Price</label>
                            <input type="text" class="form-control" name="price_per_unit">
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
    <div class="modal fade in" id="edit-grade" tabindex="-1" role="dialog" aria-labelledby="edit-grade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="edit-grade-form" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">UPDATE GRADE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="control-label">Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Category *</label>
                                <select name="category_id" class="form-control">
                                    <option>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Minimun Radius</label>
                                <input type="text" class="form-control" name="min_radius">
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Maximum Radius</label>
                                <input type="text" class="form-control" name="max_radius">
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Unite Price</label>
                                <input type="text" class="form-control" name="price_per_unit">
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

            var url = "{{ route('grade',['company_id' => Request::segment(2),'id' => '']) }}/";

            $(document).on('click','.btn-edit',function () {
                var id = $(this).data('id');
                var api_url = url +id;

                $.ajax({url: api_url, success: function(result){
                        $("#edit-grade-form").attr('action',api_url);
                        $("#edit-grade-form input[name='name']").val(result.name);
                        $("#edit-grade-form input[name='min_radius']").val(result.min_radius);
                        $("#edit-grade-form input[name='max_radius']").val(result.max_radius);
                        $("#edit-grade-form input[name='price_per_unit']").val(result.price_per_unit);
                        $("#edit-grade-form select[name='category_id']").val(result.category_id);
                    }});
            });

            $('#grades-table').DataTable()
        });
    </script>
@endsection

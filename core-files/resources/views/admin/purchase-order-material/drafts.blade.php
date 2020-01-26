@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h2>
                Material Purchase Orders (Drafts)
            </h2>
        </div>
        <div class="box-body">
            @include('layouts.partials.message')
            <table id="drafts-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>PO NO</th>
                    <th>CH NO</th>
                    <th>Vendor</th>
                    <th>Purchase Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($drafts as $draft)
                    <tr>
                        <td>{{ $draft->id }}</td>
                        <td>{{ $draft->challan_no_mannual }}</td>
                        <td>{{ $draft->vendor->name }}</td>
                        <td>{{ $draft->purchase_date }}</td>
                        <td>
                            <a href="{{ route('materialPurchaseOrders.draft', ['company_id' => Request::segment(2), 'id'=>$draft->id]) }}" type="button" class="btn btn-info pull-left">Edit</a>
                            <form action="{{ route('materialPurchaseOrders.deleteDraft', ['company_id' => Request::segment(2), 'id'=>$draft->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger pull-right">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#drafts-table').DataTable()
        });
    </script>
@endsection
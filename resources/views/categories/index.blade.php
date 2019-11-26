@extends('layouts.master')
@section('content')
    <div class="card-body">
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Baibai.vn - Chợ uy tín dành cho người bận rộn</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ route('categories.create') }}"> Create New Category</a>
                    </div>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif


            <table class="table table-bordered" id="categories-table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th width="50px">Parent ID</th>
                    <th>Name</th>
                    <th>Icon</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>

            <div id="confirmModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title">Confirmation</h2>
                        </div>
                        <div class="modal-body">
                            <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(function () {
                    $('#categories-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{!! route('categories.index') !!}',
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'parent_id', name: 'parent_id'},
                            {data: 'name', name: 'name'},
                            {data: 'icon', name: 'icon'},
                            {data: 'description', name: 'description'},
                            {data: 'action', name: 'action'},
                        ]
                    });

                    var category_id;

                    $(document).on('click', '.delete', function(){
                        category_id = $(this).attr('id');
                        $('#confirmModal').modal('show');
                    });

                    $.ajaxSetup({
                        headers:
                            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }

                    });

                    $('#ok_button').click(function(){
                        $.ajax({
                            type: "DELETE",
                            url:"categories/"+category_id,
                            beforeSend:function(){
                                $('#ok_button').text('Deleting...');
                            },
                            success:function(data)
                            {
                                setTimeout(function(){
                                    $('#confirmModal').modal('hide');
                                    $('#categories-table').DataTable().ajax.reload();
                                }, 2000);
                            }
                        })
                    });
                });
            </script>

        </div>
    </div>
@endsection

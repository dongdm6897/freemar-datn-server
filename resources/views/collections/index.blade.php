@extends('layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card-body">
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Baibai.vn - Chợ uy tín dành cho người bận rộn</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ route('collections.create') }}"> Create New Collection</a>
                    </div>
                </div>
            </div>

            {{--@if ($message = Session::get('success'))--}}
                {{--<div class="alert alert-success">--}}
                    {{--<p>{{ $message }}</p>--}}
                {{--</div>--}}
            {{--@endif--}}

            <table class="table table-bordered" id="collections_table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Search Keywords</th>
                    <th>Valid From</th>
                    <th>Valid To</th>
                    <th>Action</th>
                </tr>
                <thead>

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
                    $('#collections_table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{!! route('collections.index') !!}',
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'name', name: 'name'},
                            {data: 'image', name: 'image'},
                            {data: 'description', name: 'description'},
                            {data: 'search_keywords', name: 'search_keywords'},
                            {data: 'valid_from', name: 'valid_from'},
                            {data: 'valid_to', name: 'valid_to'},
                            {data: 'action', name: 'action'},
                        ]
                    });

                    var collection_id;

                    $(document).on('click', '.delete', function(){
                        collection_id = $(this).attr('id');
                        $('#confirmModal').modal('show');
                    });

                    $.ajaxSetup({
                        headers:
                            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }

                    });

                    $('#ok_button').click(function(){
                        $.ajax({
                            type: "DELETE",
                            url:"collections/"+collection_id,
                            beforeSend:function(){
                                $('#ok_button').text('Deleting...');
                            },
                            success:function( )
                            {
                                setTimeout(function(){
                                    $('#confirmModal').modal('hide');
                                    $('#collections_table').DataTable().ajax.reload();
                                }, 2000);
                            }
                        })
                    });
                });


            </script>

        </div>
    </div>
@endsection

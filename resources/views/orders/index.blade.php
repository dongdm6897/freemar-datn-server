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
                </div>
            </div>

            {{--@if ($message = Session::get('success'))--}}
                {{--<div class="alert alert-success">--}}
                    {{--<p>{{ $message }}</p>--}}
                {{--</div>--}}
            {{--@endif--}}

            <table class="table table-bordered" id="orders_table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Product ID</th>
                    <th>Buyer ID</th>
                    <th>Sell Price</th>
                    <th>Shipping Status ID</th>
                    <th width="280px">Action</th>
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
                    $('#orders_table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{!! route('orders.index') !!}',
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'product_id', name: 'product_id'},
                            {data: 'buyer_id', name: 'buyer_id'},
                            {data: 'sell_price', name: 'sell_price'},
                            {data: 'shipping_status_id', name: 'shipping_status_id'},
                            {data: 'action', name: 'action'},
                        ]
                    });

                    var order_id;

                    $(document).on('click', '.delete', function(){
                        order_id = $(this).attr('id');
                        $('#confirmModal').modal('show');
                    });

                    $.ajaxSetup({
                        headers:
                            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }

                    });

                    $('#ok_button').click(function(){
                        $.ajax({
                            type: "DELETE",
                            url:"orders/"+order_id,
                            beforeSend:function(){
                                $('#ok_button').text('Deleting...');
                            },
                            success:function(data)
                            {
                                setTimeout(function(){
                                    $('#confirmModal').modal('hide');
                                    $('#orders_table').DataTable().ajax.reload();
                                }, 2000);
                            }
                        })
                    });
                });


            </script>

        </div>
    </div>
@endsection

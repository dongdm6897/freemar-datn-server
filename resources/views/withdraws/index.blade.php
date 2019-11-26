@extends('layouts.master')
@section('content')
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

            <table class="table table-bordered">
                <tr>
                    <th>Id</th>
                    <th>User ID</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Created Date</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($withdrawals as $withdrawal)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $withdrawal->user_id }}</td>
                        <td>{{ $withdrawal->amount }}</td>
                        <td>{{ $withdrawal->currency }}</td>
                        <td>{{ $withdrawal->created_at }}</td>
                        <td>

                            <a class="btn btn-info"
                               href="{{ route('withdraws.shows',['payment_id' =>$withdrawal->payment_id, 'money_account_id' => $withdrawal->money_account_id]) }}">Detail</a>
                            @csrf
                            @method('GET')
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection

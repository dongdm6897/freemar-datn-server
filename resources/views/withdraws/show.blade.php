@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Withdraw Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('withdraws.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>User ID:</strong>
                {{ $user->id }}
            </div>
            <div class="form-group">
                <strong>User name:</strong>
                {{ $user->name }}
            </div>
            <div class="form-group">
                <strong>Bank Name:</strong>
                {{ $bank->name }}
            </div>
            <div class="form-group">
                <strong>Branch:</strong>
                {{ $moneyAccount->bank_branch }}
            </div>
            <div class="form-group">
                <strong>Account number:</strong>
                {{ $moneyAccount->account_number }}
            </div>
            <div class="form-group">
                <strong>Account name:</strong>
                {{ $moneyAccount->account_name }}
            </div>
            <div class="form-group">
                <strong>Amount money:</strong>
                {{ $payment->amount }}
            </div>

        </div>

    </div>

    {{--<form action="{{ route('payments.destroy',$payment->id) }}" method="POST">--}}




    <form action="{{ route('withdraws.submit',$payment->id) }}" method="POST">
    @csrf
    @method('POST')

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#checkingModal">Accept</button>
    <!-- Modal -->
    <div class="modal fade" id="checkingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn chắc chắn đã chuyển tiền cho tài khoản trên hay chưa?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection
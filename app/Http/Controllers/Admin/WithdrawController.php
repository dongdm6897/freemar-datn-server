<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CurrencyEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentTypeEnum;
use App\Http\Controllers\Client\NotificationController;
use App\Http\Controllers\Client\ObjectController;
use App\Models\MoneyAccount;
use App\Models\Payment;
use App\Models\User;
use App\Models\WithdrawRequest;
use App\Notifications\FreeMarNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class WithdrawController extends ObjectController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $withdrawals = DB::select('SELECT money_account.id AS money_account_id,money_account.account_number ,money_account.account_name ,payment.id AS payment_id,payment.amount, payment.currency,payment.user_id,payment.created_at,master_bank.name, withdraw_request.payment_id AS bank_name FROM money_account,payment,master_bank,(SELECT money_account_id,payment_id FROM withdraw_request) as withdraw_request WHERE money_account.id = withdraw_request.money_account_id and payment.id = withdraw_request.payment_id AND money_account.bank_id = master_bank.id AND payment.payment_type_id = 6');

        return view('withdraws.index', compact('withdrawals'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show($payemnt_id, $money_account_id)
    {
        $payment = Payment::find($payemnt_id);
        $moneyAccount = MoneyAccount::find($money_account_id);
        $user = User::find($moneyAccount->user_id);
        $bank = DB::table('master_bank')->where('id','=',$moneyAccount->bank_id)->first();
        return view('withdraws.show', compact('moneyAccount', 'payment', 'user','bank'));
    }

    public function updateWithdrawal(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
        ]);

        $brand->update($request->all());

        return redirect()->route('withdraws.index')
            ->with('success', 'Withdraw accepted');

    }

    public function submit($payment_id)
    {
        $payment = Payment::find($payment_id);
        if ($payment != null) {

            $this->table = 'payment';
            $this->values = ['id' => $payment->id, 'payment_type_id' => PaymentTypeEnum::WITHDRAW];
            $this->update();

            $user = User::find($payment->user_id);

            $balance_remain =$user->balance - $payment->amount;
            $this->table = 'users';
            $this->values = ['id'=> $payment->user_id,'balance' => $balance_remain];
            $this->update();



            //send notification to client
            $notification = new FreeMarNotification();
            $notification->body = "Yêu cầu rút tiền của bạn đã được thực hiện thành công, vui lòng kiêm tra lại tài khoản của bạn";
            $notification->title = "Rút tiền thành công";

            $notification->sendNotification([$payment->user_id], NotificationTypeEnum::SYSTEM, null);


            return redirect()->route('withdraws.index')
                ->with('success', 'Withdraw accepted');

        } else
            return redirect()->route('withdraws.index')
                ->with('failed', 'Withdraw failed');


    }
}

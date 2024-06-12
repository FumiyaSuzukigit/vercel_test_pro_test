<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;

class PaymentController extends Controller
{
    /**
     * 決済フォーム表示
     */
    public function create(Request $request)
    {
        return view('payment.create');
    }

    /**
     * 決済実行
     */
    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => $request->pay,
                'currency' => 'jpy',
            ]);
        } catch (Exception $e) {
            return view('payment.create')->with('flash_alert', '決済に失敗しました！('. $e->getMessage() . ')');
        }
        Reserve::find($request->id)->update(['recommendation' => $request->pay]);
        return view('thanksReserve');
    }
}

<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $amount = $request->amount * 100; // Convert to cents
        
        try {        
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'send me money',
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('payments.success'),
            'cancel_url' => route('payments.cancel'),
        ]);

        return redirect()->away($session->url);

        } catch (\Exception $e) {
            // Handle payment error in a user-friendly way
            dd($e);

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function success()
    {
        return inertia('Payments/Status' , [
            'status' => 'succeeded'
        ]);
    }

    public function cancel()
    {
        return inertia('Payments/Status' , [
            'status' => 'cancelled'
        ]);
    }
}

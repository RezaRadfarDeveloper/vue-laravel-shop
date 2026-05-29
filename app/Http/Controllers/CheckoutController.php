<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
       public function checkout() {
      $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

      $checkout_session = $stripe->checkout->sessions->create([
          'line_items' => [[
            'price_data' => [
              'currency' => 'usd',
              'product_data' => [
                'name' => 'T-shirt',
              ],
              'unit_amount' => 2000 * 100,
            ],
            'quantity' => 1,
          ]],
          'mode' => 'payment',
          'success_url' => route("checkout.success",[],true).'?session_id={CHECKOUT_SESSION_ID}',
        ]);


return redirect($checkout_session->url);
    }

    public function success(Request $request) {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

try {
  $session = $stripe->checkout->sessions->retrieve($request->session_id);
//   $customer_account = $stripe->v2->core->accounts->retrieve($session->customer_details);
 
 
} catch (Exception $e) {
    
  return view('checkout.failure');
}
        return view('checkout.success',compact('session'));
    }

    // public function failure() {
    //     return 
    // }
}

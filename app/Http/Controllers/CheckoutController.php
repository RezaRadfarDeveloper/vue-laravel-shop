<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Cart;
use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
       public function checkout(Request $request) {
      $user = $request->user();
      $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

      $oldCart = Session::has('cart') ? Session::get('cart'): null;
      $cart = new Cart($oldCart);
      list($products,$totalPrice) = $cart->getCartItems();
     $line_items = [];

      foreach($products as $product) {
        
       $line_Items[]= [
          'price_data' => [
              'currency' => 'usd',
              'product_data' => [
                'name' => $product['item']['title'],
              ],
              'unit_amount' => $product['item']['price']* 100,
            ],
            'quantity' =>$product['qty'],
        ];

      };

      // dd($line_Items);


      $checkout_session = $stripe->checkout->sessions->create([
          'line_items' => $line_Items,
          'mode' => 'payment',
          'success_url' => route("checkout.success",[],true).'?session_id={CHECKOUT_SESSION_ID}',
        ]);

        $orderDetails = [
          'status' => 'unpaid',
          'total_price' => $totalPrice,
          'created_by' =>$user->id,
          'updated_by' =>$user->id,
        ];


        if(!$checkout_session) {
          return view('checkout.failure');
        }

        $order = Order::create($orderDetails);


        $paymentDetails = [
          'type'=>'cc',
          'amount'=> $totalPrice,
          'order_id' => $order->id,
          'status' => 'pending',
          'session_id' => $checkout_session->id,
          'created_by' =>$user->id,
          'updated_by' =>$user->id,
        ];

        $payment = Payment::create($paymentDetails);
       



return redirect($checkout_session->url);
    }

    public function success(Request $request) {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
      $oldCart = Session::has('cart') ? Session::get('cart'): null;


try {
  

  $session = $stripe->checkout->sessions->retrieve($request->session_id);
  $payment = Payment::query()->where(['session_id'=> $session->id, 'status'=>'pending'])->first();
  
  if(!$payment) {
    return view('checkout.failure',['message'=>'error with payment']);
  }
 
  $payment->status = 'paid'; 
  $payment->update();

  $order = $payment->order;
  

  $order->status = 'paid';
  $order->update();

      $cart = new Cart($oldCart);
      $cart->emptyCart();
      Session::forget('cart');


//   $customer_account = $stripe->v2->core->accounts->retrieve($session->customer_details);
} catch (Exception $e) {
    
  return view('checkout.failure',['message'=>$e->getMessage()]);
}




        return view('checkout.success',compact('session'));
    }

    

    public function failure() {
         return view('checkout.success', ['message'=> 'Your payment was not successful']);
    }

    public function checkoutSingleOrder(Order $order, Request $request) {
      dd($order);
    }
}

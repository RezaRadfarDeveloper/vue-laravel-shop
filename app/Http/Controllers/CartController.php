<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index() {
        return view('cart.index');
    }

    public function addToCart(Request $request, $id) {
        $product = Product::findOrFail($id);
        $oldCart = Session::has('cart') ? Session::get('cart'): null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
    return redirect()->back();
    }

     public function removeFromCart(Request $request, $id) {
        $product = Product::findOrFail($id);
        $oldCart = Session::has('cart') ? Session::get('cart'): null;
        $cart = new Cart($oldCart);
        $cart->removeOne($product, $product->id);

      if(!count($cart->items)) {
         Session::forget('cart');
      }
      else {
        $request->session()->put('cart', $cart);
      }
      
    return redirect()->back();
    }

     public function removeItemFromCart(Request $request, $id) {
        $product = Product::findOrFail($id);
        $oldCart = Session::has('cart') ? Session::get('cart'): null;
        $cart = new Cart($oldCart);
        $cart->removeItem($product, $product->id);

      if(!count($cart->items)) {
         Session::forget('cart');
      }
      else {
        $request->session()->put('cart', $cart);
      }
      
    return redirect()->back();
    }

    public function showCart() {
        if(!Session::has('cart')) {
            return view('cart.show');
        }
        else {
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            return view('cart.show',['products'=>$cart->items, 'totalPrice'=> $cart->totalPrice]);
        }
    }

}

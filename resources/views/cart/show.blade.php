<x-app-layout>
<div>
    @if(Session::has('cart'))
    <ul>
        @foreach ($products as $product)
        <li>
            <span>{{$product['qty']}}</span>
            <span>{{$product['item']['title']}}</span>
            <span>{{$product['price']}}</span>
            <a href="{{route('add-to-cart', ['id'=>$product['item']['id']])}}">add 1</a>
            <a href="{{route('remove-from-cart', ['id'=>$product['item']['id']])}}">reduce 1</a>
            <a href="{{route('remove-item-from-cart', ['id'=>$product['item']['id']])}}">remove item</a>
        </li>
            
        @endforeach
    </ul>
    <div>
        <span>total price: {{$totalPrice}}</span>
        <a class="block py-2 px-4 text-center cursor-pointer mx-auto mt-24 w-48 bg-green-500"><span class="text-white">Check out</span></a>
    </div>
    <form action="{{route('cart.checkout')}}" method="POST">
        @csrf
      <button type="submit">Checkout</button>
    </form>
    @else
    <h1>No product is added to cart</h1>
    @endif
</div>
</x-app-layout>
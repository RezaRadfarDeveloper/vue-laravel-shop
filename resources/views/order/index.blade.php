<x-app-layout>
   <div class="flex flex-col">
    @foreach ($orders as $order)
    <div >
      <span class="text-blue-400">{{$order->id}}</span>
  <span>{{$order->total_price}}</span>
  <a href="{{route('order.view',['order'=> $order])}}"> Check order</a>
  <span class=" px-3 py-2 rounded {{$order->isPaid() ? 'bg-emerald-500' : 'bg-gray-300'}}">{{$order->status}}</span>
  <span>{{$order->items()->count()}} item(s)</span>
   @if(!$order->isPaid())
   <form action="{{route('cart.checkout-single-order',$order)}}" method="POST">
   @csrf
    <button class="bg-purple-400 px-3 py-2 rounded">Pay</button>
    </form>
    @endif
    @endforeach
   </div>
   </div>
   {{$orders->links()}}
</x-app-layout>
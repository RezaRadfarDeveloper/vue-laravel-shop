<x-app-layout>
   <div>
    @foreach ($orders as $order)
  <span>{{$order->total_price}}</span>
  <a href="{{route('order.view',['order'=> $order])}}"> Check order</a>
  <span>{{$order->status}}</span>
    @endforeach
   </div>
   {{$orders->links()}}
</x-app-layout>
<x-app-layout>
   <div class="flex flex-col">
      <h1>Order details</h1>
      <div>
            <span> #{{$order->id}}</span>
            <span class=" px-3 py-2 rounded {{$order->isPaid() ? 'bg-emerald-500' : 'bg-gray-300'}}"> {{$order->status}}</span>
            <span> {{$order->total_price}}</span>
            <span> {{$order->created_at}}</span>
            <span> {{$order->id}}</span>
       </div>
      <div> 
         @foreach ($order->items as $item) 
         <div class="flex justify-start gap-2">
            <span class="block w-20 h-20"><img src="{{$item->product->image}}" width="80px"  height="80px" alt="image {{$item->id}}"></span>
            <span>{{$item->unit_price}}</span>
            <span>{{$item->product->title}}</span>
            <span>{{$item->quantity}}</span>
             </div>  
         @endforeach
         
      </div>
         <div>
            @if(!$order->isPaid())
               <form action="{{route('cart.checkout-single-order',$order)}}" method="POST">
               @csrf
               <button class="bg-purple-400 px-3 py-2 rounded">Pay</button>
               </form>
            @endif
      </div>
   </div>
</x-app-layout>
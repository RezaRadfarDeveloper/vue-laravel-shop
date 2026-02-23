<x-app-layout>
   <div>
    @foreach ($products as $product)
        <span>{{$product->name}}</span>
        <img class="w-8 h-8" src="{{$product->image}}" alt="{{$product->name}}">
        <div>{{$product->title}}</div>
        <div>{{$product->price}}</div>
    @endforeach
   </div>
   {{$products->links()}}
</x-app-layout>
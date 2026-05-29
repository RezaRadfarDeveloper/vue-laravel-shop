<x-app-layout>
   <div>
    @foreach ($products as $product)
    <a href="{{route('product.view', $product)}}">
        <span>{{$product->name}}</span>
        <img class="w-8 h-8" src="{{$product->image}}" alt="{{$product->name}}">
        <div>{{$product->title}}</div>
        <div>{{$product->price}}</div>
        <a href="{{route('add-to-cart', ['id'=>$product->id])}}" >add to cart</a>
    </a>
    @endforeach
   </div>
   {{$products->links()}}
</x-app-layout>
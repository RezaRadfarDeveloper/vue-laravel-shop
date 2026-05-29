<x-app-layout>
   
        <span>{{$product->name}}</span>
        <img class="w-8 h-8" src="{{$product->image}}" alt="{{$product->name}}">
        <div>{{$product->title}}</div>
        <div>{{$product->price}}</div>
 
</x-app-layout>
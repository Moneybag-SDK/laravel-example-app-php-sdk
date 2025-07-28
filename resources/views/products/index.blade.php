@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1>Our Products</h1>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
        @foreach($products as $product)
            <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                <h3>{{ $product->name }}</h3>
                <p>{{ $product->description }}</p>
                <p style="font-size: 1.2em; font-weight: bold; color: #007bff;">৳{{ number_format($product->price, 2) }}</p>
                <p>Stock: {{ $product->stock }}</p>
                
                <form action="{{ route('cart.add') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 60px; padding: 5px;">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </div>
        @endforeach
    </div>
    
    @if($products->isEmpty())
        <p>No products available at the moment.</p>
    @endif
@endsection
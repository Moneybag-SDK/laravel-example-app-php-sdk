@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <h1>Shopping Cart</h1>
    
    @if(!empty($cart))
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="border-bottom: 2px solid #ddd;">
                    <th style="text-align: left; padding: 10px;">Product</th>
                    <th style="text-align: center; padding: 10px;">Price</th>
                    <th style="text-align: center; padding: 10px;">Quantity</th>
                    <th style="text-align: center; padding: 10px;">Subtotal</th>
                    <th style="text-align: center; padding: 10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">{{ $item['name'] }}</td>
                        <td style="text-align: center; padding: 10px;">৳{{ number_format($item['price'], 2) }}</td>
                        <td style="text-align: center; padding: 10px;">{{ $item['quantity'] }}</td>
                        <td style="text-align: center; padding: 10px;">৳{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td style="text-align: center; padding: 10px;">
                            <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; padding: 10px; font-weight: bold;">Total:</td>
                    <td style="text-align: center; padding: 10px; font-weight: bold;">৳{{ number_format($total, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        
        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="{{ route('checkout.index') }}" class="btn">Proceed to Checkout</a>
            <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Clear Cart</button>
            </form>
            <a href="{{ route('products.index') }}" class="btn" style="background: #6c757d;">Continue Shopping</a>
        </div>
    @else
        <p>Your cart is empty.</p>
        <a href="{{ route('products.index') }}" class="btn">Start Shopping</a>
    @endif
@endsection
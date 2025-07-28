@extends('layouts.app')

@section('title', 'Payment Cancelled')

@section('content')
    <div style="text-align: center; padding: 40px;">
        <h1 style="color: #dc3545;">Payment Cancelled</h1>
        
        <div style="font-size: 4em; color: #dc3545; margin: 20px 0;">✗</div>
        
        <p style="font-size: 1.2em; margin: 20px 0;">
            Your payment has been cancelled. Your order has not been processed.
        </p>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 30px auto; max-width: 500px;">
            <h3>Order Information</h3>
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Total Amount:</strong> ৳{{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Status:</strong> Cancelled</p>
        </div>
        
        <div style="margin-top: 30px;">
            <a href="{{ route('cart.index') }}" class="btn">Return to Cart</a>
            <a href="{{ route('products.index') }}" class="btn" style="background: #6c757d; margin-left: 10px;">Continue Shopping</a>
        </div>
    </div>
@endsection
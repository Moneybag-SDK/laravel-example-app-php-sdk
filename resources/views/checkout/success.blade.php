@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
    <div style="text-align: center; padding: 40px;">
        <h1 style="color: #28a745;">Payment Successful!</h1>
        
        <div style="font-size: 4em; color: #28a745; margin: 20px 0;">✓</div>
        
        <p style="font-size: 1.2em; margin: 20px 0;">
            Thank you for your order! Your payment has been processed successfully.
        </p>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 30px auto; max-width: 500px;">
            <h3>Order Details</h3>
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Total Amount:</strong> ৳{{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
            @if($order->moneybag_transaction_id)
                <p><strong>Transaction ID:</strong> {{ $order->moneybag_transaction_id }}</p>
            @endif
        </div>
        
        <div style="margin-top: 30px;">
            <a href="{{ route('orders.show', $order) }}" class="btn">View Order Details</a>
            <a href="{{ route('products.index') }}" class="btn" style="background: #6c757d; margin-left: 10px;">Continue Shopping</a>
        </div>
    </div>
@endsection
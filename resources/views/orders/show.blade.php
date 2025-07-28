@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <h1>Order Details</h1>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 20px;">
        <div>
            <h2>Order Information</h2>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 10px;">
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                <p><strong>Payment Status:</strong> 
                    <span style="padding: 5px 10px; border-radius: 4px; 
                               background: {{ $order->payment_status === 'paid' ? '#d4edda' : ($order->payment_status === 'pending' ? '#fff3cd' : '#f8d7da') }}; 
                               color: {{ $order->payment_status === 'paid' ? '#155724' : ($order->payment_status === 'pending' ? '#856404' : '#721c24') }};">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </p>
                @if($order->moneybag_transaction_id)
                    <p><strong>Transaction ID:</strong> {{ $order->moneybag_transaction_id }}</p>
                @endif
            </div>
        </div>
        
        <div>
            <h2>Customer Information</h2>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 10px;">
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Shipping Address:</strong><br>{{ nl2br($order->shipping_address) }}</p>
            </div>
        </div>
    </div>
    
    <h2 style="margin-top: 40px;">Order Items</h2>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="border-bottom: 2px solid #ddd;">
                <th style="text-align: left; padding: 10px;">Product</th>
                <th style="text-align: center; padding: 10px;">Price</th>
                <th style="text-align: center; padding: 10px;">Quantity</th>
                <th style="text-align: center; padding: 10px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px;">{{ $item->product->name }}</td>
                    <td style="text-align: center; padding: 10px;">৳{{ number_format($item->price, 2) }}</td>
                    <td style="text-align: center; padding: 10px;">{{ $item->quantity }}</td>
                    <td style="text-align: center; padding: 10px;">৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; padding: 10px; font-weight: bold;">Total:</td>
                <td style="text-align: center; padding: 10px; font-weight: bold;">৳{{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    
    <div style="margin-top: 30px;">
        <a href="{{ route('orders.index') }}" class="btn" style="background: #6c757d;">Back to Orders</a>
    </div>
@endsection
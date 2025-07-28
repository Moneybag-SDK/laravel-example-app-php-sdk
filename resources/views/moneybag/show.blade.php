@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
    <h1>Moneybag Transaction Details</h1>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 20px;">
        <div>
            <h2>Transaction Information</h2>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 10px;">
                <p><strong>Transaction ID:</strong> {{ $transaction->id }}</p>
                <p><strong>Session ID:</strong> <span style="font-family: monospace;">{{ $transaction->checkout_id }}</span></p>
                <p><strong>Moneybag Transaction ID:</strong> 
                    @if($transaction->transaction_id)
                        <span style="font-family: monospace;">{{ $transaction->transaction_id }}</span>
                    @else
                        <span style="color: #999;">Not available</span>
                    @endif
                </p>
                <p><strong>Status:</strong> 
                    <span style="padding: 5px 10px; border-radius: 4px; 
                               background: {{ $transaction->status === 'completed' ? '#d4edda' : ($transaction->status === 'pending' ? '#fff3cd' : '#f8d7da') }}; 
                               color: {{ $transaction->status === 'completed' ? '#155724' : ($transaction->status === 'pending' ? '#856404' : '#721c24') }};">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </p>
                <p><strong>Amount:</strong> ৳{{ number_format($transaction->amount, 2) }} {{ $transaction->currency }}</p>
                <p><strong>Created:</strong> {{ $transaction->created_at->format('Y-m-d H:i:s') }}</p>
                @if($transaction->payment_completed_at)
                    <p><strong>Completed:</strong> {{ $transaction->payment_completed_at->format('Y-m-d H:i:s') }}</p>
                @endif
            </div>
        </div>
        
        <div>
            <h2>Order Information</h2>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 10px;">
                <p><strong>Order Number:</strong> <a href="{{ route('orders.show', $transaction->order) }}">{{ $transaction->order->order_number }}</a></p>
                <p><strong>Customer:</strong> {{ $transaction->order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $transaction->order->customer_email }}</p>
                <p><strong>Phone:</strong> {{ $transaction->order->customer_phone }}</p>
                <p><strong>Total Amount:</strong> ৳{{ number_format($transaction->order->total_amount, 2) }}</p>
            </div>
        </div>
    </div>
    
    <h2 style="margin-top: 40px;">Request Data</h2>
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 10px;">
        <pre style="white-space: pre-wrap; word-wrap: break-word; margin: 0; font-size: 0.9em;">{{ json_encode($transaction->request_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
    
    <h2 style="margin-top: 30px;">Response Data</h2>
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 10px;">
        <pre style="white-space: pre-wrap; word-wrap: break-word; margin: 0; font-size: 0.9em;">{{ json_encode($transaction->response_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
    
    <h2 style="margin-top: 30px;">Order Items</h2>
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
            @foreach($transaction->order->items as $item)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px;">{{ $item->product->name }}</td>
                    <td style="text-align: center; padding: 10px;">৳{{ number_format($item->price, 2) }}</td>
                    <td style="text-align: center; padding: 10px;">{{ $item->quantity }}</td>
                    <td style="text-align: center; padding: 10px;">৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 30px;">
        <a href="{{ route('moneybag.transactions') }}" class="btn" style="background: #6c757d;">Back to Transactions</a>
        <a href="{{ route('orders.show', $transaction->order) }}" class="btn" style="margin-left: 10px;">View Order</a>
    </div>
@endsection
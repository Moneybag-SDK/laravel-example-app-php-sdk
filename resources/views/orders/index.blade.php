@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <h1>Orders</h1>
    
    @if($orders->count() > 0)
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="border-bottom: 2px solid #ddd;">
                    <th style="text-align: left; padding: 10px;">Order Number</th>
                    <th style="text-align: left; padding: 10px;">Date</th>
                    <th style="text-align: left; padding: 10px;">Customer</th>
                    <th style="text-align: center; padding: 10px;">Total</th>
                    <th style="text-align: center; padding: 10px;">Payment Status</th>
                    <th style="text-align: center; padding: 10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">{{ $order->order_number }}</td>
                        <td style="padding: 10px;">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td style="padding: 10px;">{{ $order->customer_name }}</td>
                        <td style="text-align: center; padding: 10px;">৳{{ number_format($order->total_amount, 2) }}</td>
                        <td style="text-align: center; padding: 10px;">
                            <span style="padding: 5px 10px; border-radius: 4px; 
                                       background: {{ $order->payment_status === 'paid' ? '#d4edda' : ($order->payment_status === 'pending' ? '#fff3cd' : '#f8d7da') }}; 
                                       color: {{ $order->payment_status === 'paid' ? '#155724' : ($order->payment_status === 'pending' ? '#856404' : '#721c24') }};">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td style="text-align: center; padding: 10px;">
                            <a href="{{ route('orders.show', $order) }}" class="btn">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="margin-top: 20px;">
            {{ $orders->links() }}
        </div>
    @else
        <p>No orders found.</p>
    @endif
@endsection
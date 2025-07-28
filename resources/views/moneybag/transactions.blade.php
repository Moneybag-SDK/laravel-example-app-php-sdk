@extends('layouts.app')

@section('title', 'Moneybag Transactions')

@section('content')
    <h1>Moneybag Transactions</h1>
    
    @if($transactions->count() > 0)
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="border-bottom: 2px solid #ddd;">
                    <th style="text-align: left; padding: 10px;">ID</th>
                    <th style="text-align: left; padding: 10px;">Order</th>
                    <th style="text-align: left; padding: 10px;">Session ID</th>
                    <th style="text-align: left; padding: 10px;">Transaction ID</th>
                    <th style="text-align: center; padding: 10px;">Amount</th>
                    <th style="text-align: center; padding: 10px;">Status</th>
                    <th style="text-align: center; padding: 10px;">Created</th>
                    <th style="text-align: center; padding: 10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">{{ $transaction->id }}</td>
                        <td style="padding: 10px;">
                            <a href="{{ route('orders.show', $transaction->order) }}" style="color: #007bff;">
                                {{ $transaction->order->order_number }}
                            </a>
                        </td>
                        <td style="padding: 10px; font-family: monospace; font-size: 0.9em;">
                            {{ substr($transaction->checkout_id, 0, 8) }}...
                        </td>
                        <td style="padding: 10px; font-family: monospace; font-size: 0.9em;">
                            @if($transaction->transaction_id)
                                {{ substr($transaction->transaction_id, 0, 8) }}...
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        <td style="text-align: center; padding: 10px;">৳{{ number_format($transaction->amount, 2) }}</td>
                        <td style="text-align: center; padding: 10px;">
                            <span style="padding: 5px 10px; border-radius: 4px; font-size: 0.9em;
                                       background: {{ $transaction->status === 'completed' ? '#d4edda' : ($transaction->status === 'pending' ? '#fff3cd' : '#f8d7da') }}; 
                                       color: {{ $transaction->status === 'completed' ? '#155724' : ($transaction->status === 'pending' ? '#856404' : '#721c24') }};">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td style="text-align: center; padding: 10px;">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                        <td style="text-align: center; padding: 10px;">
                            <a href="{{ route('moneybag.show', $transaction) }}" class="btn" style="font-size: 0.9em; padding: 5px 10px;">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="margin-top: 20px;">
            {{ $transactions->links() }}
        </div>
    @else
        <p>No Moneybag transactions found.</p>
    @endif
@endsection
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MoneybagTransaction;
use Illuminate\Http\Request;
use Moneybag\MoneybagClient;
use Moneybag\Models\CheckoutRequest;

class CheckoutController extends Controller
{
    private $moneybag;

    public function __construct()
    {
        $this->moneybag = new MoneybagClient(config('moneybag.merchant_api_key'), [
            'base_url' => config('moneybag.api_url')
        ]);
    }

    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postcode' => 'required|string|max:20',
            'country' => 'required|string|max:2',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'order_number' => 'ORD' . uniqid(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->postcode,
            'country' => $request->country,
            'total_amount' => $total,
            'payment_status' => 'pending',
        ]);

        // Create order items
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Initialize Moneybag checkout
        try {
            $checkoutData = [
                'order_id' => $order->order_number,
                'currency' => 'BDT',
                'order_amount' => number_format($total, 2, '.', ''),
                'order_description' => 'Order #' . $order->order_number,
                'success_url' => route('payment.success', ['order' => $order->id]),
                'cancel_url' => route('payment.cancel', ['order' => $order->id]),
                'fail_url' => route('payment.cancel', ['order' => $order->id]),
                'customer' => [
                    'name' => $order->customer_name,
                    'email' => $order->customer_email,
                    'address' => $order->shipping_address,
                    'city' => $order->city,
                    'postcode' => $order->zipcode,
                    'country' => $order->country,
                    'phone' => $order->customer_phone,
                ],
            ];

            $checkoutRequest = new CheckoutRequest($checkoutData);
            $response = $this->moneybag->createCheckout($checkoutRequest);
            
            // Save checkout reference
            $sessionId = $response->getSessionId();
            $order->update([
                'payment_reference' => $sessionId ?? $order->order_number,
                'moneybag_transaction_id' => $sessionId,
            ]);

            // Save transaction record
            MoneybagTransaction::create([
                'order_id' => $order->id,
                'checkout_id' => $sessionId,
                'status' => 'pending',
                'amount' => $total,
                'currency' => 'BDT',
                'request_data' => $checkoutData,
                'response_data' => [
                    'session_id' => $sessionId,
                    'checkout_url' => $response->getCheckoutUrl(),
                    'expires_at' => $response->getExpiresAt(),
                ],
            ]);

            // Clear cart
            session()->forget('cart');

            // Redirect to Moneybag checkout page
            return redirect($response->getCheckoutUrl());

        } catch (\Exception $e) {
            return redirect()->route('checkout.index')
                ->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    public function paymentCallback(Request $request)
    {
        try {
            $transactionId = $request->input('transaction_id');
            
            if ($transactionId) {
                $response = $this->moneybag->verifyPayment($transactionId);
                
                $order = Order::where('order_number', $response->getOrderId())->first();
                
                if ($order) {
                    $order->update([
                        'payment_status' => $response->isSuccessful() ? 'paid' : 'failed',
                        'moneybag_transaction_id' => $transactionId,
                    ]);
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function paymentSuccess(Request $request, Order $order)
    {
        // Verify payment if transaction_id is provided
        $transactionId = $request->query('transaction_id');
        
        if ($transactionId) {
            try {
                $response = $this->moneybag->verifyPayment($transactionId);
                
                if ($response->isSuccessful()) {
                    $order->update([
                        'payment_status' => 'paid',
                        'moneybag_transaction_id' => $transactionId,
                    ]);

                    // Update transaction record
                    $transaction = MoneybagTransaction::where('order_id', $order->id)
                        ->where('checkout_id', $order->payment_reference)
                        ->first();
                    
                    if ($transaction) {
                        $transaction->update([
                            'transaction_id' => $transactionId,
                            'status' => 'completed',
                            'response_data' => array_merge($transaction->response_data ?? [], [
                                'transaction_id' => $transactionId,
                                'verified' => true,
                                'verified_at' => now(),
                            ]),
                            'payment_completed_at' => now(),
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Log error but continue to show success page
            }
        }
        
        return view('checkout.success', compact('order'));
    }

    public function paymentCancel(Order $order)
    {
        return view('checkout.cancel', compact('order'));
    }
}
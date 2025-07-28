@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h1>Checkout</h1>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 20px;">
        <div>
            <h2>Billing Information</h2>
            <form action="{{ route('checkout.process') }}" method="POST" style="margin-top: 20px;">
                @csrf
                
                <div style="margin-bottom: 15px;">
                    <label for="customer_name" style="display: block; margin-bottom: 5px;">Full Name:</label>
                    <input type="text" id="customer_name" name="customer_name" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('customer_name')
                        <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="customer_email" style="display: block; margin-bottom: 5px;">Email:</label>
                    <input type="email" id="customer_email" name="customer_email" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('customer_email')
                        <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="customer_phone" style="display: block; margin-bottom: 5px;">Phone:</label>
                    <input type="tel" id="customer_phone" name="customer_phone" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('customer_phone')
                        <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="shipping_address" style="display: block; margin-bottom: 5px;">Shipping Address:</label>
                    <textarea id="shipping_address" name="shipping_address" required rows="3"
                              style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                    @error('shipping_address')
                        <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="city" style="display: block; margin-bottom: 5px;">City:</label>
                    <input type="text" id="city" name="city" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('city')
                        <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="state" style="display: block; margin-bottom: 5px;">State/Division:</label>
                    <select id="state" name="state" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Select State/Division</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Chattogram">Chattogram</option>
                        <option value="Rajshahi">Rajshahi</option>
                        <option value="Khulna">Khulna</option>
                        <option value="Barisal">Barisal</option>
                        <option value="Sylhet">Sylhet</option>
                        <option value="Rangpur">Rangpur</option>
                        <option value="Mymensingh">Mymensingh</option>
                    </select>
                    @error('state')
                        <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="postcode" style="display: block; margin-bottom: 5px;">Postal Code:</label>
                    <input type="text" id="postcode" name="postcode" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('postcode')
                        <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="country" style="display: block; margin-bottom: 5px;">Country:</label>
                    <select id="country" name="country" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="BD" selected>Bangladesh</option>
                    </select>
                    @error('country')
                        <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn">Proceed to Payment</button>
            </form>
        </div>
        
        <div>
            <h2>Order Summary</h2>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px;">
                @foreach($cart as $item)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                        <span>৳{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @endforeach
                
                <hr style="margin: 20px 0;">
                
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2em;">
                    <span>Total:</span>
                    <span>৳{{ number_format($total, 2) }}</span>
                </div>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #e3f2fd; border-radius: 8px;">
                <p style="text-align: center;">
                    <strong>Secure Payment</strong><br>
                    Your payment will be processed securely through Moneybag Payment Gateway
                </p>
            </div>
        </div>
    </div>
@endsection
@extends('notification::emails.layout')

@section('title', 'Order Confirmation')

@section('content')
<h2>Order Confirmation</h2>

<p>Dear {{ $customer->name }},</p>

<p>Thank you for your order! We're excited to confirm that we've received your order and it's being processed.</p>

<div class="order-details">
    <h3>Order Details</h3>
    <p><strong>Order Number:</strong> #{{ $order->id }}</p>
    <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    
    <h4>Items Ordered:</h4>
    @foreach($items as $item)
    <div class="order-item">
        <p><strong>{{ $item->product->name ?? 'Product' }}</strong></p>
        <p>Quantity: {{ $item->quantity }}</p>
        <p>Price: ${{ number_format($item->price, 2) }}</p>
        <p>Subtotal: ${{ number_format($item->quantity * $item->price, 2) }}</p>
    </div>
    @endforeach
    
    <div class="order-item">
        <p class="total">Total: ${{ number_format($order->total_amount, 2) }}</p>
    </div>
</div>

<p>We'll send you another email when your order ships. You can also track your order status by logging into your account.</p>

<a href="{{ url('/orders/' . $order->id) }}" class="button">View Order Details</a>

<p>Thank you for shopping with us!</p>

<p>Best regards,<br>The Digi Team</p>
@endsection
@extends('notification::emails.layout')

@section('title', 'Vendor Order Notification')

@section('content')
@if($notificationType === 'new_order')
<h2>New Order Received!</h2>

<p>Dear {{ $vendor->name }},</p>

<p>Great news! You've received a new order on Digi.</p>

@elseif($notificationType === 'order_cancelled')
<h2>Order Cancelled</h2>

<p>Dear {{ $vendor->name }},</p>

<p>We wanted to inform you that an order has been cancelled.</p>

@elseif($notificationType === 'payment_received')
<h2>Payment Received</h2>

<p>Dear {{ $vendor->name }},</p>

<p>Payment has been successfully received for your order.</p>

@else
<h2>Order Update</h2>

<p>Dear {{ $vendor->name }},</p>

<p>There's an update regarding one of your orders.</p>
@endif

<div class="order-details">
    <h3>Order Information</h3>
    <p><strong>Order Number:</strong> #{{ $order->id }}</p>
    <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
    <p><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    
    <h4>Your Items in this Order:</h4>
    @php
        $vendorItems = $items->filter(function($item) use ($vendor) {
            return $item->product && $item->product->vendor_id === $vendor->id;
        });
        $vendorTotal = $vendorItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
    @endphp
    
    @forelse($vendorItems as $item)
    <div class="order-item">
        <p><strong>{{ $item->product->name ?? 'Product' }}</strong></p>
        <p>Quantity: {{ $item->quantity }}</p>
        <p>Price: ${{ number_format($item->price, 2) }}</p>
        <p>Subtotal: ${{ number_format($item->quantity * $item->price, 2) }}</p>
    </div>
    @empty
    <p>No items found for your vendor account in this order.</p>
    @endforelse
    
    @if($vendorItems->count() > 0)
    <div class="order-item">
        <p class="total">Your Total: ${{ number_format($vendorTotal, 2) }}</p>
    </div>
    @endif
</div>

@if($notificationType === 'new_order')
<p>Please log in to your vendor dashboard to process this order and update its status.</p>

<a href="{{ url('/vendor/orders/' . $order->id) }}" class="button">View Order Details</a>

<div class="order-details">
    <h3>Next Steps</h3>
    <ul>
        <li>Review the order details carefully</li>
        <li>Confirm product availability</li>
        <li>Update the order status as you process it</li>
        <li>Prepare items for shipping</li>
        <li>Provide tracking information when available</li>
    </ul>
</div>

@elseif($notificationType === 'payment_received')
<p>The payment has been processed successfully. You can now proceed with order fulfillment.</p>

<a href="{{ url('/vendor/orders/' . $order->id) }}" class="button">Process Order</a>

@else
<p>Please check your vendor dashboard for more details and take any necessary actions.</p>

<a href="{{ url('/vendor/orders/' . $order->id) }}" class="button">View Order</a>
@endif

<p>Thank you for being a valued vendor partner!</p>

<p>Best regards,<br>The Digi Vendor Team</p>
@endsection
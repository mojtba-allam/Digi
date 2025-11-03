@extends('notification::emails.layout')

@section('title', 'Welcome to Digi')

@section('content')
<h2>Welcome to Digi!</h2>

<p>Dear {{ $user->name }},</p>

<p>Welcome to Digi! We're thrilled to have you join our community of shoppers and vendors.</p>

<p>Your account has been successfully created with the email address: <strong>{{ $user->email }}</strong></p>

@if($verificationUrl)
<p>To get started, please verify your email address by clicking the button below:</p>

<a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>

<p>If the button doesn't work, you can copy and paste this link into your browser:</p>
<p style="word-break: break-all; color: #666;">{{ $verificationUrl }}</p>
@endif

<div class="order-details">
    <h3>What's Next?</h3>
    <ul>
        <li>Complete your profile to get personalized recommendations</li>
        <li>Browse our extensive catalog of products</li>
        <li>Set up your preferences and notifications</li>
        <li>Start shopping and enjoy exclusive member benefits</li>
    </ul>
</div>

<p>If you have any questions or need assistance, our support team is here to help.</p>

<a href="{{ url('/') }}" class="button">Start Shopping</a>

<p>Welcome aboard!</p>

<p>Best regards,<br>The Digi Team</p>
@endsection
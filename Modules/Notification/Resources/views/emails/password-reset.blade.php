@extends('notification::emails.layout')

@section('title', 'Reset Your Password')

@section('content')
<h2>Password Reset Request</h2>

<p>Dear {{ $user->name }},</p>

<p>We received a request to reset the password for your Digi account associated with {{ $user->email }}.</p>

<p>To reset your password, click the button below:</p>

<a href="{{ $resetUrl }}" class="button">Reset Password</a>

<p>If the button doesn't work, you can copy and paste this link into your browser:</p>
<p style="word-break: break-all; color: #666;">{{ $resetUrl }}</p>

<div class="order-details">
    <h3>Security Information</h3>
    <ul>
        <li>This password reset link will expire in 60 minutes</li>
        <li>If you didn't request this password reset, please ignore this email</li>
        <li>Your password will remain unchanged until you create a new one</li>
        <li>For security reasons, we recommend using a strong, unique password</li>
    </ul>
</div>

<p><strong>Didn't request this?</strong> If you didn't request a password reset, you can safely ignore this email. Your account remains secure.</p>

<p>If you're having trouble with the reset process or have security concerns, please contact our support team immediately.</p>

<p>Best regards,<br>The Digi Security Team</p>
@endsection
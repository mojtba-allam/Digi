@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Order {{ $order->formatted_order_number }}</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                {{ ucfirst($order->status) }}
            </span>
            @if(count($availableStatuses) > 0)
            <button onclick="openStatusModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                Update Status
            </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                @if($item->product && $item->product->image)
                                <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" class="w-16 h-16 rounded-lg object-cover">
                                @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $item->display_name }}</h4>
                                        @if($item->product_sku)
                                        <p class="text-sm text-gray-500">SKU: {{ $item->product_sku }}</p>
                                        @endif
                                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                                            <span>Qty: {{ $item->quantity }}</span>
                                            <span>Price: ${{ number_format($item->price, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">${{ number_format($item->total, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Order Totals -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Discount</span>
                            <span class="text-green-600">-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        @if($order->shipping_amount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-gray-900">${{ number_format($order->shipping_amount, 2) }}</span>
                        </div>
                        @endif
                        @if($order->tax_amount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax</span>
                            <span class="text-gray-900">${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-base font-medium border-t border-gray-200 pt-2">
                            <span class="text-gray-900">Total</span>
                            <span class="text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($order->orderStatuses as $index => $statusHistory)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-{{ match($statusHistory->status) { 'pending' => 'yellow', 'confirmed' => 'blue', 'processing' => 'indigo', 'shipped' => 'purple', 'delivered' => 'green', 'cancelled' => 'red', 'refunded' => 'gray', default => 'gray' } }}-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    @if($statusHistory->status === 'delivered')
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    @elseif($statusHistory->status === 'cancelled')
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    @else
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    @endif
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-900">
                                                    Order status changed to <span class="font-medium">{{ ucfirst($statusHistory->status) }}</span>
                                                </p>
                                                @if($statusHistory->notes)
                                                <p class="mt-1 text-sm text-gray-500">{{ $statusHistory->notes }}</p>
                                                @endif
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $statusHistory->created_at->toISOString() }}">
                                                    {{ $statusHistory->created_at->format('M j, Y g:i A') }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Customer</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ substr($order->user->name ?? 'N', 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">{{ $order->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if($order->user)
                    <div class="mt-4 space-y-2">
                        <div class="text-sm">
                            <span class="text-gray-500">Customer since:</span>
                            <span class="text-gray-900">{{ $order->user->created_at->format('M Y') }}</span>
                        </div>
                        <div class="text-sm">
                            <span class="text-gray-500">Total orders:</span>
                            <span class="text-gray-900">{{ $order->user->orders()->count() }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Shipping Address -->
            @if($order->shipping_address)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Shipping Address</h3>
                </div>
                <div class="p-6">
                    <div class="text-sm text-gray-900 whitespace-pre-line">{{ $order->formatted_shipping_address }}</div>
                </div>
            </div>
            @endif

            <!-- Billing Address -->
            @if($order->billing_address)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Billing Address</h3>
                </div>
                <div class="p-6">
                    <div class="text-sm text-gray-900 whitespace-pre-line">{{ $order->formatted_billing_address }}</div>
                </div>
            </div>
            @endif

            <!-- Payment Information -->
            @if($order->payment)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Payment</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Method:</span>
                        <span class="text-gray-900">{{ ucfirst($order->payment->payment_method ?? 'N/A') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Status:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $order->payment->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->payment->status ?? 'Pending') }}
                        </span>
                    </div>
                    @if($order->payment->transaction_id)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Transaction ID:</span>
                        <span class="text-gray-900 font-mono text-xs">{{ $order->payment->transaction_id }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Order Notes -->
            @if($order->notes)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Notes</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-900">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modal -->
@if(count($availableStatuses) > 0)
<div id="status-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="status-form">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Update Order Status
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="new-status" class="block text-sm font-medium text-gray-700">New Status</label>
                                    <select id="new-status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @foreach($availableStatuses as $status)
                                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="status-notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                                    <textarea id="status-notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Add any notes about this status change..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Status
                    </button>
                    <button type="button" onclick="closeStatusModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
function openStatusModal() {
    document.getElementById('status-modal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('status-modal').classList.add('hidden');
    document.getElementById('status-form').reset();
}

document.getElementById('status-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {
        status: formData.get('status'),
        notes: formData.get('notes')
    };

    fetch('{{ route("admin.orders.update-status", $order) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the order status');
    });
});

// Close modal when clicking outside
document.getElementById('status-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStatusModal();
    }
});
</script>
@endpush


@endsection
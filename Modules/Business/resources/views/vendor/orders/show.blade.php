@extends('layouts.vendor')

@section('title', 'Order Details - ' . $order->formatted_order_number)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('vendor.orders.index') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Order {{ $order->formatted_order_number }}</h1>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                    @elseif($order->status === 'processing') bg-indigo-100 text-indigo-800
                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <p class="text-gray-600 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
        </div>
        <div class="flex space-x-3">
            @if(count($availableStatuses) > 0)
                <button onclick="showStatusUpdateModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Update Status
                </button>
            @endif
            <button onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-print mr-2"></i>Print
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <div class="px-6 py-4">
                            <div class="flex items-start space-x-4">
                                @if($item->product && $item->product->image)
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->display_name }}</h3>
                                    <p class="text-sm text-gray-500">SKU: {{ $item->product_sku }}</p>
                                    
                                    @if($item->product_options && count($item->product_options) > 0)
                                        <div class="mt-1">
                                            @foreach($item->product_options as $key => $value)
                                                <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs mr-1">
                                                    {{ ucfirst($key) }}: {{ $value }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">
                                        ${{ number_format($item->price, 2) }} × {{ $item->quantity }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Total: ${{ number_format($item->total, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Order Totals -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount:</span>
                                <span class="text-green-600">-${{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping:</span>
                            <span class="text-gray-900">${{ number_format($order->shipping_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax:</span>
                            <span class="text-gray-900">${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-base font-semibold border-t border-gray-200 pt-2">
                            <span class="text-gray-900">Total:</span>
                            <span class="text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Order Timeline</h2>
                </div>
                <div class="px-6 py-4">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($order->orderStatuses as $index => $status)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                                    @if($status->status === 'pending') bg-yellow-500
                                                    @elseif($status->status === 'confirmed') bg-blue-500
                                                    @elseif($status->status === 'processing') bg-indigo-500
                                                    @elseif($status->status === 'shipped') bg-purple-500
                                                    @elseif($status->status === 'delivered') bg-green-500
                                                    @elseif($status->status === 'cancelled') bg-red-500
                                                    @else bg-gray-500
                                                    @endif">
                                                    <i class="fas fa-check text-white text-sm"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-900 font-medium">
                                                        Order {{ ucfirst($status->status) }}
                                                    </p>
                                                    @if($status->notes)
                                                        <p class="text-sm text-gray-500">{{ $status->notes }}</p>
                                                    @endif
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    {{ $status->created_at->format('M d, Y g:i A') }}
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
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Customer Information</h2>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            @if($order->shipping_address)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Shipping Address</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="text-sm text-gray-900 whitespace-pre-line">{{ $order->formatted_shipping_address }}</div>
                    </div>
                </div>
            @endif

            <!-- Billing Address -->
            @if($order->billing_address)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Billing Address</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="text-sm text-gray-900 whitespace-pre-line">{{ $order->formatted_billing_address }}</div>
                    </div>
                </div>
            @endif

            <!-- Payment Information -->
            @if($order->payment)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Payment Information</h2>
                    </div>
                    <div class="px-6 py-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Method:</span>
                            <span class="text-gray-900">{{ ucfirst($order->payment->method ?? 'N/A') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Status:</span>
                            <span class="text-gray-900">{{ ucfirst($order->payment->status ?? 'N/A') }}</span>
                        </div>
                        @if($order->payment->transaction_id)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Transaction ID:</span>
                                <span class="text-gray-900 font-mono text-xs">{{ $order->payment->transaction_id }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            @if(count($availableStatuses) > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="px-6 py-4 space-y-2">
                        @foreach($availableStatuses as $status)
                            <button onclick="quickStatusUpdate('{{ $status }}')" 
                                    class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                Mark as {{ ucfirst($status) }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusUpdateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Update Order Status</h3>
            </div>
            <form id="statusUpdateForm" class="px-6 py-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Status</label>
                    <select id="newStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select status...</option>
                        @foreach($availableStatuses as $status)
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4" id="trackingNumberField" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tracking Number</label>
                    <input type="text" id="trackingNumber" name="tracking_number" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter tracking number">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea id="statusNotes" name="notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Add any notes about this status update..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeStatusUpdateModal()" 
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showStatusUpdateModal() {
    document.getElementById('statusUpdateModal').classList.remove('hidden');
    
    // Show/hide tracking number field based on status
    document.getElementById('newStatus').addEventListener('change', function() {
        const trackingField = document.getElementById('trackingNumberField');
        if (this.value === 'shipped') {
            trackingField.style.display = 'block';
        } else {
            trackingField.style.display = 'none';
        }
    });
}

function closeStatusUpdateModal() {
    document.getElementById('statusUpdateModal').classList.add('hidden');
    document.getElementById('statusUpdateForm').reset();
}

function quickStatusUpdate(status) {
    if (confirm(`Are you sure you want to mark this order as ${status}?`)) {
        updateOrderStatus(status);
    }
}

function updateOrderStatus(status, notes = '', trackingNumber = '') {
    const formData = new FormData();
    formData.append('status', status);
    if (notes) formData.append('notes', notes);
    if (trackingNumber) formData.append('tracking_number', trackingNumber);
    
    fetch(`/vendor/orders/{{ $order->id }}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeStatusUpdateModal();
            location.reload(); // Refresh the page to show updated status
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the order status.');
    });
}

document.getElementById('statusUpdateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const status = document.getElementById('newStatus').value;
    const notes = document.getElementById('statusNotes').value;
    const trackingNumber = document.getElementById('trackingNumber').value;
    
    updateOrderStatus(status, notes, trackingNumber);
});
</script>
@endpush
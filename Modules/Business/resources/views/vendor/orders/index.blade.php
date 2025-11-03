@extends('layouts.vendor')

@section('title', 'My Orders')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Orders</h1>
            <p class="text-gray-600">Manage and track your order fulfillment</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="refreshOrders()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-sync-alt mr-2"></i>Refresh
            </button>
        </div>
    </div>

    <!-- Status Filter Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="flex flex-wrap border-b border-gray-200">
            <a href="{{ route('vendor.orders.index') }}" 
               class="px-6 py-3 text-sm font-medium {{ !request('status') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                All Orders
                <span class="ml-2 bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">{{ $statusCounts['all'] }}</span>
            </a>
            <a href="{{ route('vendor.orders.index', ['status' => 'pending']) }}" 
               class="px-6 py-3 text-sm font-medium {{ request('status') === 'pending' ? 'text-yellow-600 border-b-2 border-yellow-600' : 'text-gray-500 hover:text-gray-700' }}">
                Pending
                <span class="ml-2 bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-xs">{{ $statusCounts['pending'] }}</span>
            </a>
            <a href="{{ route('vendor.orders.index', ['status' => 'confirmed']) }}" 
               class="px-6 py-3 text-sm font-medium {{ request('status') === 'confirmed' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                Confirmed
                <span class="ml-2 bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs">{{ $statusCounts['confirmed'] }}</span>
            </a>
            <a href="{{ route('vendor.orders.index', ['status' => 'processing']) }}" 
               class="px-6 py-3 text-sm font-medium {{ request('status') === 'processing' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                Processing
                <span class="ml-2 bg-indigo-100 text-indigo-600 px-2 py-1 rounded-full text-xs">{{ $statusCounts['processing'] }}</span>
            </a>
            <a href="{{ route('vendor.orders.index', ['status' => 'shipped']) }}" 
               class="px-6 py-3 text-sm font-medium {{ request('status') === 'shipped' ? 'text-purple-600 border-b-2 border-purple-600' : 'text-gray-500 hover:text-gray-700' }}">
                Shipped
                <span class="ml-2 bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-xs">{{ $statusCounts['shipped'] }}</span>
            </a>
            <a href="{{ route('vendor.orders.index', ['status' => 'delivered']) }}" 
               class="px-6 py-3 text-sm font-medium {{ request('status') === 'delivered' ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                Delivered
                <span class="ml-2 bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">{{ $statusCounts['delivered'] }}</span>
            </a>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('vendor.orders.index') }}" class="flex flex-wrap gap-4">
            <input type="hidden" name="status" value="{{ request('status') }}">
            
            <div class="flex-1 min-w-64">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by order number or customer name..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="flex gap-2">
                <input type="date" 
                       name="date_from" 
                       value="{{ request('date_from') }}"
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <input type="date" 
                       name="date_to" 
                       value="{{ request('date_to') }}"
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('vendor.orders.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Items
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $order->formatted_order_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->user->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->user->email ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->items->count() }} items
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('vendor.orders.show', $order) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(in_array($order->status, ['confirmed', 'processing']))
                                            <button onclick="showStatusUpdateModal({{ $order->id }}, '{{ $order->status }}')"
                                                    class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
                <p class="text-gray-500">
                    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                        Try adjusting your filters to see more results.
                    @else
                        Orders will appear here once customers start purchasing your products.
                    @endif
                </p>
            </div>
        @endif
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
                <input type="hidden" id="orderId" name="order_id">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Status</label>
                    <select id="newStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select status...</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
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
function showStatusUpdateModal(orderId, currentStatus) {
    document.getElementById('orderId').value = orderId;
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

document.getElementById('statusUpdateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const orderId = document.getElementById('orderId').value;
    const formData = new FormData(this);
    
    fetch(`/vendor/orders/${orderId}/status`, {
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
});

function refreshOrders() {
    location.reload();
}
</script>
@endpush
@extends('admin.layout')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-serif font-bold text-mocha-text mb-1">Dashboard Overview</h1>
        <p class="text-gray-500 text-sm">Welcome to the Elm Grove administration panel.</p>
    </div>
    
    <!-- Order Toggle Switch -->
    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between space-x-6">
        <div>
            <h3 class="text-sm font-bold text-mocha-text">Accepting Orders</h3>
            <p class="text-[10px] text-gray-500 uppercase tracking-wider">Global System Toggle</p>
        </div>
        <form action="{{ route('admin.settings.toggleOrders') }}" method="POST">
            @csrf
            @php
                $ordersEnabled = \App\Models\AdminSetting::where('key', 'orders_enabled')->first()->value ?? 'true';
            @endphp
            <button type="submit" class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $ordersEnabled === 'true' ? 'bg-mocha-accent' : 'bg-gray-200' }}" role="switch">
                <span class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow-md ring-0 transition duration-200 ease-in-out {{ $ordersEnabled === 'true' ? 'translate-x-5' : 'translate-x-0' }}"></span>
            </button>
        </form>
    </div>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 relative overflow-hidden group shadow-sm hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-mocha-accent/5 rounded-full group-hover:bg-mocha-accent/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-mocha-accent/10 rounded-xl text-mocha-accent">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 11v1m-6-10h.223a2 2 0 001.8.117A2 2 0 0112 16c-1.11 0-2.08-.402-2.599-1M12 16v1M6 10v1m12-1v1m-6-10h.223a2 2 0 001.8.117"></path></svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-500 mb-1">Total Revenue</p>
        <p class="text-2xl font-bold text-mocha-text">${{ number_format($totalRevenue, 2) }}</p>
    </div>
    
    <div class="bg-white rounded-2xl border border-gray-100 p-6 relative overflow-hidden group shadow-sm hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/5 rounded-full group-hover:bg-blue-500/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-500 mb-1">Total Orders</p>
        <p class="text-2xl font-bold text-mocha-text">{{ number_format($totalOrders) }}</p>
    </div>
    
    <div class="bg-white rounded-2xl border border-gray-100 p-6 relative overflow-hidden group shadow-sm hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/5 rounded-full group-hover:bg-purple-500/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-500 mb-1">Total Products</p>
        <p class="text-2xl font-bold text-mocha-text">{{ number_format($totalProducts) }}</p>
    </div>
    
    <div class="bg-white rounded-2xl border border-gray-100 p-6 relative overflow-hidden group shadow-sm hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-500/5 rounded-full group-hover:bg-green-500/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-50 rounded-xl text-green-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <p class="text-sm font-medium text-gray-500 mb-1">Registered Users</p>
        <p class="text-2xl font-bold text-mocha-text">{{ number_format($totalUsers) }}</p>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-mocha-text">Recent Orders</h3>
        <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-mocha-accent hover:text-[#A0522D] transition-colors">View All</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-700">
                        <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-mocha-accent font-bold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-mocha-text">
                        {{ $order->user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $order->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-mocha-text">
                        ${{ number_format($order->total, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-mocha-accent/10 text-mocha-accent capitalize">
                            {{ $order->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                        No orders have been placed yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

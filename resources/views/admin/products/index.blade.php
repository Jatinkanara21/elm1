@extends('admin.layout')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-serif font-bold text-mocha-text mb-1">Manage Products</h1>
        <p class="text-gray-500 text-sm">View, create, and edit products.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-mocha-accent hover:bg-[#A0522D] text-white font-semibold py-2.5 px-5 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md text-sm">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add New Product
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
        <input type="text" placeholder="Search products..." class="bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-700 focus:ring-mocha-accent focus:border-mocha-accent w-64 shadow-sm">
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($product->image)
                                <img class="h-10 w-10 rounded-full object-cover bg-gray-100 p-0.5 border border-gray-100" src="{{ Storage::url($product->image) }}" alt="">
                            @else
                                <div class="h-10 w-10 rounded-full bg-mocha-accent/10 flex items-center justify-center border border-mocha-accent/20 text-xs text-mocha-accent font-bold">IMG</div>
                            @endif
                            <div class="ml-4">
                                <div class="text-sm font-bold text-mocha-text">{{ $product->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-mocha-text">
                        ${{ number_format($product->price, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $product->stock }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-mocha-accent hover:text-[#A0522D] font-bold mr-3">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600 font-bold" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $products->links() }}
    </div>
</div>
@endsection

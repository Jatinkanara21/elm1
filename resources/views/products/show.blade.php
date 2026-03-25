@extends('layouts.main')

@section('title', $product->name)

@section('content')
<div class="bg-white/80 py-4 border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-mocha-accent transition-colors">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        <a href="{{ route('products.index', ['category' => $product->category->slug ?? '']) }}" class="hover:text-mocha-accent transition-colors">{{ $product->category->name ?? 'Category' }}</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        <span class="text-gray-700 line-clamp-1 font-medium">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Product Details Detail -->
    <div class="glassmorphism rounded-2xl overflow-hidden border border-white/10 p-6 md:p-12 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <!-- Product Image -->
            <div class="flex justify-center items-center bg-gray-50 rounded-xl p-8 min-h-[400px] border border-gray-100">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" loading="eager" decoding="async" class="max-h-96 object-contain drop-shadow-md">
                @else
                    <div class="w-32 h-64 bg-mocha-accent/10 rounded-t-full rounded-b-lg border-2 border-mocha-accent/30 flex items-center justify-center">
                        <span class="text-mocha-accent/50 text-sm font-serif rotate-90">{{ $product->category->name ?? 'BOTTLE' }}</span>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col justify-center">
                @if($product->brand)
                    <p class="text-mocha-accent font-bold tracking-widest uppercase text-sm mb-2">{{ $product->brand }}</p>
                @endif
                <h1 class="text-3xl sm:text-4xl font-serif font-bold text-mocha-text mb-4">{{ $product->name }}</h1>
                
                <!-- Rating Summary -->
                @php
                    $avgRating = $product->reviews->avg('rating') ?: 0;
                    $reviewCount = $product->reviews->count();
                @endphp
                <div class="flex items-center mb-6">
                    <div class="flex text-yellow-500 text-sm">
                        @for($i=1; $i<=5; $i++)
                            @if($i <= $avgRating)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endif
                        @endfor
                    </div>
                    <span class="ml-2 text-sm text-gray-500">({{ $reviewCount }} reviews)</span>
                </div>

                <div class="text-3xl font-bold text-mocha-text mb-6">${{ number_format($product->price, 2) }}</div>
                
                <p class="text-gray-600 leading-relaxed mb-8">{{ $product->description }}</p>

                <div class="flex items-center space-x-4">
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full flex">
                        @csrf
                        <button type="submit" class="flex-1 bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-4 px-8 rounded-lg shadow-lg transition-colors flex justify-center items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Add to Cart
                        </button>
                    </form>
                    
                    <form action="{{ route('wishlist.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-mocha-secondary hover:bg-gray-800 border border-white/20 text-white p-4 rounded-lg transition-colors flex items-center justify-center tooltip" title="Add to Wishlist">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </form>
                </div>
                
                <div class="mt-8 pt-8 border-t border-white/10 flex items-center text-sm text-gray-400">
                    <svg class="h-5 w-5 mr-2 text-mocha-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>In Stock ({{ $product->stock }} available)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-16">
        <h2 class="text-2xl font-serif font-bold text-mocha-text mb-8 border-b border-gray-100 pb-4">Customer Reviews</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Review Form -->
            <div class="lg:col-span-1">
                <div class="glassmorphism p-6 rounded-xl bg-white/90">
                    <h3 class="text-lg font-bold text-mocha-text mb-4">Write a Review</h3>
                    @auth
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                <select name="rating" class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent">
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Average</option>
                                    <option value="2">2 - Poor</option>
                                    <option value="1">1 - Terrible</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Review</label>
                                <textarea name="comment" rows="4" class="w-full bg-white border-gray-200 rounded-md text-gray-800 focus:ring-mocha-accent" required></textarea>
                            </div>
                            <button class="w-full bg-mocha-accent hover:bg-[#A0522D] text-white font-bold py-2 px-4 rounded transition-colors shadow-sm">Submit Review</button>
                        </form>
                    @else
                        <div class="bg-gray-50 border border-gray-100 p-4 rounded text-center">
                            <p class="text-sm text-gray-600 mb-3">Please log in to write a review.</p>
                            <a href="{{ route('login') }}" class="inline-block bg-mocha-accent text-white px-4 py-2 rounded text-sm font-bold shadow-sm">Log in</a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Review List -->
            <div class="lg:col-span-2 space-y-6">
                @forelse($product->reviews->where('is_approved', 1) as $review)
                    <div class="border-b border-gray-100 pb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-mocha-text">{{ $review->user->name }}</span>
                            <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex text-yellow-500 text-xs mb-3">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-200 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic">No reviews yet. Be the first to review this product!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

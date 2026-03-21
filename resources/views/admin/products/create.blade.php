@extends('admin.layout')

@section('content')
<div class="mb-8 flex items-center space-x-4">
    <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-mocha-accent transition-colors">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h1 class="text-3xl font-serif font-bold text-mocha-text">Add New Product</h1>
</div>

<div class="bg-white rounded-2xl border border-gray-100 p-8 max-w-2xl shadow-sm">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-5">
            <x-input-label for="name" value="Product Name" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-5">
            <x-input-label for="category_id" value="Category" />
            <select name="category_id" id="category_id" class="mt-1 block w-full bg-white border border-gray-200 rounded-xl text-gray-700 focus:ring-mocha-accent focus:border-mocha-accent shadow-sm py-2 px-3" required>
                <option value="" disabled selected>Select a Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <x-input-label for="price" value="Price ($)" />
                <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('price') }}" required />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="stock" value="Stock Count" />
                <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full" value="{{ old('stock') }}" required />
                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
            </div>
        </div>

        <div class="mb-5">
            <x-input-label for="brand" value="Brand (Optional)" />
            <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full" value="{{ old('brand') }}" />
            <x-input-error :messages="$errors->get('brand')" class="mt-2" />
        </div>

        <div class="mb-5">
            <x-input-label for="description" value="Description" />
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full bg-white border border-gray-200 rounded-xl text-gray-700 focus:ring-mocha-accent focus:border-mocha-accent shadow-sm py-2 px-3">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="image" value="Product Image" />
            <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-mocha-accent/10 file:text-mocha-accent hover:file:bg-mocha-accent/20 cursor-pointer">
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                Create Product
            </x-primary-button>
        </div>
    </form>
</div>
@endsection

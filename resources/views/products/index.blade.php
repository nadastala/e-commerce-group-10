<x-app-layout>
    <div class="max-w-7xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-4">All Products</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <div class="border rounded-lg p-4">
                    <h2 class="font-semibold text-lg">{{ $product->name }}</h2>
                    <p class="text-gray-600">Rp {{ number_format($product->price) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

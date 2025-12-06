<?php
//app/Http/Controllers/Seller/StoreController.php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function create()
    {
        return view('seller.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'terms' => 'required|accepted'
        ]);

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('stores/banners', 'public');
        }

        $validated['buyer_id'] = auth()->id();
        $validated['status'] = 'pending';

        Store::create($validated);

        return redirect()->route('seller.register')
            ->with('success', 'Store registration submitted successfully! Please wait for admin approval.');
    }

    public function edit()
    {
        $store = auth()->user()->store;
        
        if (!$store || !$store->isApproved()) {
            abort(403);
        }

        return view('seller.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = auth()->user()->store;
        
        if (!$store || !$store->isApproved()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string'
        ]);

        // Handle file uploads
        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $validated['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($store->banner) {
                Storage::disk('public')->delete($store->banner);
            }
            $validated['banner'] = $request->file('banner')->store('stores/banners', 'public');
        }

        $store->update($validated);

        return redirect()->route('seller.store.edit')
            ->with('success', 'Store updated successfully!');
    }
}

// app/Http/Controllers/Seller/DashboardController.php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        
        // Statistics
        $totalProducts = $store->products()->count();
        $totalOrders = Transaction::whereHas('items', function($query) use ($store) {
            $query->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            });
        })->count();
        
        $totalRevenue = Transaction::whereHas('items', function($query) use ($store) {
            $query->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            });
        })->where('status', 'completed')->sum('total');
        
        $pendingOrders = Transaction::whereHas('items', function($query) use ($store) {
            $query->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            });
        })->where('status', 'pending')->count();

        // Recent orders
        $recentOrders = Transaction::with(['buyer', 'items.product'])
            ->whereHas('items', function($query) use ($store) {
                $query->whereHas('product', function($q) use ($store) {
                    $q->where('store_id', $store->id);
                });
            })
            ->latest()
            ->take(5)
            ->get();

        // Low stock products
        $lowStockProducts = $store->products()
            ->where('stock', '<', 10)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'store',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}

// app/Http/Controllers/Seller/ProductController.php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $products = $store->products()
            ->with(['category', 'images'])
            ->latest()
            ->paginate(12);

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'season' => 'required|in:summer,winter,spring,fall,all',
            'images.*' => 'nullable|image|max:2048'
        ]);

        $validated['store_id'] = auth()->user()->store->id;
        
        $product = Product::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_url' => $path,
                    'is_primary' => $index === 0,
                    'order' => $index
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        // Ensure product belongs to seller's store
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        $categories = ProductCategory::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Ensure product belongs to seller's store
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'season' => 'required|in:summer,winter,spring,fall,all'
        ]);

        $product->update($validated);

        return redirect()->route('seller.products.edit', $product)
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Ensure product belongs to seller's store
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        // Delete images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function show(Product $product)
    {
        // Ensure product belongs to seller's store
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        $product->load(['category', 'images', 'reviews.user']);
        
        return view('seller.products.show', compact('product'));
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image'], $data['cropped_image']);

        $data['slug'] = Str::slug($request->name) . '-' . Str::random(5);

        // Handle Cropper.js base64 cropped image or file upload
        if ($request->filled('cropped_image')) {
            $data['image'] = $this->storeCroppedImage($request->cropped_image);
        } elseif ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image'], $data['cropped_image']);

        // Handle Cropper.js cropped image or standard upload
        if ($request->filled('cropped_image')) {
            $this->deleteOldImage($product->image);
            $data['image'] = $this->storeCroppedImage($request->cropped_image);
        } elseif ($request->hasFile('image')) {
            $this->deleteOldImage($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage (Admin Only).
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Enforce RBAC: only Admin / delete-products permission
        if (! auth()->user()->can('delete-products')) {
            abort(403, 'Unauthorized action. Only Admins can delete products.');
        }

        $this->deleteOldImage($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Store base64 data URL from Cropper.js to public disk.
     */
    protected function storeCroppedImage(string $base64String): string
    {
        // Expecting format: data:image/png;base64,xxxxx or data:image/jpeg;base64,xxxxx
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
            $imageData = substr($base64String, strpos($base64String, ',') + 1);
            $decodedData = base64_decode($imageData);

            $fileName = 'products/' . Str::uuid() . '.' . $extension;
            Storage::disk('public')->put($fileName, $decodedData);

            return $fileName;
        }

        return '';
    }

    /**
     * Delete existing product image from storage if stored locally.
     */
    protected function deleteOldImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}


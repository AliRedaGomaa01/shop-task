<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CategoryService;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(
        public CategoryService $categoryService ,
    )
    { 
        
    }

    /**
     * Display search form
     */
    public function search()
    {
        $categories = $this->categoryService->getCategories();
        return inertia('Products/Search' , compact('categories'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        $products = Product::query()
            ->with('category')->get();

        return inertia('Products/Index', ['products' => $products]);
    }

    public function searchResult(Request $request)
    {
        $products = Product::query()
            ->ofTitle($request->title)
            ->ofCategory($request->category_id)
            ->ofDetails($request->details)
            ->moreThanPrice($request->minPrice)        
            ->lessThanPrice($request->maxPrice) 
            ->with('category')->get();
        return inertia('Products/Index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->getCategories();
        return inertia('Products/Create' , compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        //  store image 

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = time() . rand(10000, 9999999) . '.' . $extension;
            $validated['image'] = 'storage/' . $request->file('image')->storeAs('products' , $newName , 'public');
        }

        $product = Product::create($validated);

        return redirect()->route('products.show' , $product->id)->with('success', 'stored successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return inertia('Products/Show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('category');
        $categories = $this->categoryService->getCategories();
        return inertia('Products/Edit' , compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        //  store image 

        if ($request->hasFile('image')) {
            // delete old image
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            // store new image
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = time() . rand(10000, 9999999) . '.' . $extension;
            $validated['image'] = 'storage/' . $request->file('image')->storeAs('products' , $newName , 'public');
        }

        $product->update($validated);

        return redirect()->route('products.show' , $product->id)->with('success', 'updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // delete image
        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'deleted successfully.');
    }
}

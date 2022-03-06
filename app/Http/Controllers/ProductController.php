<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('view', 'products');
        return ProductResource::collection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        Gate::authorize('edit', 'products');
        $fileName = md5(time()).'.'.$request->file('image')->extension();

        $url = Storage::disk('public')->putFileAs('images',$request->file('image'), $fileName);

        $product = Product::create($request->except('image') + ['image'=> $url]);

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        Gate::authorize('view', 'products');
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        Gate::authorize('edit', 'products');
        $data = $request->except('image');
        if($request->hasFile('image')){
            $fileName = md5(time()).'.'.$request->file('image')->extension();
            $url = Storage::disk('public')->putFileAs('images',$request->file('image'), $fileName);
            $data['image']  = $url;
        }

        $product->update($data);

        return response(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Gate::authorize('view', 'products');
        return response(null, Response::HTTP_NO_CONTENT);
    }
}

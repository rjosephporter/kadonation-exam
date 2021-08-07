<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/products",
     *      security={{"bearerAuth": {}}},
     *      tags={"Products"},
     *      summary="Get list of products",
     *
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          @OA\Schema(type="integer")
     *      ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product")),
     *              @OA\Property(property="links", type="object", ref="#/components/schemas/PaginationLinks"),
     *              @OA\Property(property="meta", type="object", ref="#/components/schemas/PaginationMeta"),
     *          ),
     *      )
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResource::collection(Product::paginate());
    }

    /**
     * @OA\Post(
     *      path="/products",
     *      security={{"bearerAuth": {}}},
     *      tags={"Products"},
     *      summary="Store a product",
     *
     *     requestBody={"$ref": "#/components/requestBodies/ProductRequest"},
     *
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Product"),
     *          ),
     *      ),
     *      @OA\Response(response="401", description="Unauthenticated")
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ProductResource
     */
    public function store(ProductRequest $request)
    {
        return new ProductResource(Product::create($request->all())->load('category'));
    }

    /**
     * @OA\Get(
     *      path="/products/{product_id}",
     *      tags={"Products"},
     *      summary="Show a product",
     *
     *     @OA\Parameter(
     *          name="product_id",
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Product"),
     *          ),
     *      )
     * )
     *
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * @OA\Patch (
     *      path="/products/{product_id}",
     *      security={{"bearerAuth": {}}},
     *      tags={"Products"},
     *      summary="Update a product",
     *
     *     @OA\Parameter(
     *          name="product_id",
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *
     *     requestBody={"$ref": "#/components/requestBodies/ProductRequest"},
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Product"),
     *          ),
     *      ),
     *      @OA\Response(response="401", description="Unauthenticated")
     * )
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return ProductResource
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return new ProductResource($product->refresh());
    }

    /**
     * @OA\Delete(
     *      path="/products/{product_id}",
     *      security={{"bearerAuth": {}}},
     *      tags={"Products"},
     *      summary="Delete a product",
     *
     *     @OA\Parameter(
     *          name="product_id",
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Product"),
     *          ),
     *      ),
     *      @OA\Response(response="401", description="Unauthenticated")
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return ProductResource
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return new ProductResource($product);
    }
}

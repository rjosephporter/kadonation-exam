<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/categories",
     *      security={{"bearerAuth": {}}},
     *      tags={"Categories"},
     *      summary="Get list of categories",
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
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Category")),
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
        return CategoryResource::collection(Category::paginate());
    }

    /**
     * @OA\Post(
     *      path="/categories",
     *      security={{"bearerAuth": {}}},
     *      tags={"Categories"},
     *      summary="Store a category",
     *
     *     requestBody={"$ref": "#/components/requestBodies/CategoryRequest"},
     *
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Category"),
     *          ),
     *      ),
     *      @OA\Response(response="401", description="Unauthenticated")
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request)
    {
        return new CategoryResource(Category::create($request->all()));
    }

    /**
     * @OA\Get(
     *      path="/categories/{category_id}",
     *      tags={"Categories"},
     *      summary="Show a category",
     *
     *     @OA\Parameter(
     *          name="category_id",
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Category"),
     *          ),
     *      )
     * )
     *
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * @OA\Patch (
     *      path="/categories/{category_id}",
     *      security={{"bearerAuth": {}}},
     *      tags={"Categories"},
     *      summary="Update a category",
     *
     *     @OA\Parameter(
     *          name="category_id",
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *
     *     requestBody={"$ref": "#/components/requestBodies/CategoryRequest"},
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Category"),
     *          ),
     *      ),
     *      @OA\Response(response="401", description="Unauthenticated")
     * )
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return CategoryResource
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        return new CategoryResource($category->refresh());
    }

    /**
     * @OA\Delete(
     *      path="/categories/{category_id}",
     *      security={{"bearerAuth": {}}},
     *      tags={"Categories"},
     *      summary="Delete a category",
     *
     *     @OA\Parameter(
     *          name="category_id",
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/Category"),
     *          ),
     *      ),
     *      @OA\Response(response="401", description="Unauthenticated")
     * )
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return CategoryResource
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return new CategoryResource($category);
    }
}

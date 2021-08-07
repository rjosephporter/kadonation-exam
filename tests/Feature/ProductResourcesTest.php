<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductResourcesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canIndexIfUnauthenticated()
    {
        Product::factory()->count(20)->create();

        $response = $this->getJson(route('api.products.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    /** @test */
    public function canIndexIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        Product::factory()->count(20)->create();

        $response = $this->getJson(route('api.products.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    /** @test */
    public function canStoreIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        $product = Product::factory()->make()->toArray();

        $response = $this->postJson(route('api.products.store'), $product);

        unset($product['category_id']);

        $response->assertCreated();
        $response->assertJsonFragment($product);
    }

    /** @test */
    public function cannotStoreIfUnauthenticated()
    {
        $product = Product::factory()->make()->toArray();

        $response = $this->postJson(route('api.products.store'), $product);

        $response->assertUnauthorized();
    }

    /** @test */
    public function canShowIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $response = $this->getJson(route('api.products.show', ['product' => $product->id]));

        $response->assertOk();
        $response->assertJsonFragment($product->makeHidden('category_id')->toArray());
    }

    /** @test */
    public function canShowIfUnauthenticated()
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('api.products.show', ['product' => $product->id]));

        $response->assertOk();
        $response->assertJsonFragment($product->makeHidden('category_id')->toArray());
    }

    /** @test */
    public function canUpdateIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        $product = Product::factory()->create();
        $updateProduct = Product::factory()->make();

        $response = $this->patchJson(route('api.products.update', ['product' => $product->id]), $updateProduct->toArray());

        $response->assertOk();
        $response->assertJsonFragment($updateProduct->makeHidden('category_id')->toArray());
    }

    /** @test */
    public function cannotUpdateIfUnauthenticated()
    {
        $product = Product::factory()->create();
        $updateProduct = Product::factory()->make()->toArray();

        $response = $this->patchJson(route('api.products.update', ['product' => $product->id]), $updateProduct);

        $response->assertUnauthorized();
    }

    /** @test */
    public function canDestroyIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $response = $this->deleteJson(route('api.products.destroy', ['product' => $product->id]));

        $response->assertOk();
        $this->assertDeleted('products', $product->toArray());
    }

    /** @test */
    public function cannotDestroyIfUnauthenticated()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('api.products.destroy', ['product' => $product->id]));

        $response->assertUnauthorized();
    }
}

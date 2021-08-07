<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryResourcesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canIndexIfUnauthenticated()
    {
        Category::factory()->count(20)->create();

        $response = $this->getJson(route('api.categories.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    /** @test */
    public function canIndexIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        Category::factory()->count(20)->create();

        $response = $this->getJson(route('api.categories.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    /** @test */
    public function canStoreIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->make()->toArray();

        $response = $this->postJson(route('api.categories.store'), $category);

        $response->assertCreated();
        $response->assertJsonFragment($category);
    }

    /** @test */
    public function cannotStoreIfUnauthenticated()
    {
        $category = Category::factory()->make();

        $response = $this->postJson(route('api.categories.store'), $category->toArray());

        $response->assertUnauthorized();
    }

    /** @test */
    public function canShowIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $response = $this->getJson(route('api.categories.show', ['category' => $category->id]));

        $response->assertOk();
        $response->assertJsonFragment($category->toArray());
    }

    /** @test */
    public function canShowIfUnauthenticated()
    {
        $category = Category::factory()->create();

        $response = $this->getJson(route('api.categories.show', ['category' => $category->id]));

        $response->assertOk();
        $response->assertJsonFragment($category->toArray());
    }

    /** @test */
    public function canUpdateIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->create();
        $updateCategory = Category::factory()->make();

        $response = $this->patchJson(route('api.categories.update', ['category' => $category->id]), $updateCategory->toArray());

        $response->assertOk();
        $response->assertJsonFragment($updateCategory->makeHidden('category_id')->toArray());
    }

    /** @test */
    public function cannotUpdateIfUnauthenticated()
    {
        $category = Category::factory()->create();
        $updateCategory = Category::factory()->make()->toArray();

        $response = $this->patchJson(route('api.categories.update', ['category' => $category->id]), $updateCategory);

        $response->assertUnauthorized();
    }

    /** @test */
    public function canDestroyIfAuthenticated()
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $response = $this->deleteJson(route('api.categories.destroy', ['category' => $category->id]));

        $response->assertOk();
        $this->assertDeleted('categories', $category->toArray());
    }

    /** @test */
    public function cannotDestroyIfUnauthenticated()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson(route('api.categories.destroy', ['category' => $category->id]));

        $response->assertUnauthorized();
    }
}

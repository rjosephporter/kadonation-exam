<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema()
 */
class Product extends Model
{
    use HasFactory;

    /**
     * @OA\Property(property="id", type="integer", example=5),
     * @OA\Property(property="name", type="string", example="Cyberpunk 2077"),
     * @OA\Property(property="category", type="object", ref="#/components/schemas/Category"),
     * @OA\Property(property="sku", type="string", example="A0005"),
     * @OA\Property(property="price", type="number", example=59.99),
     * @OA\Property(property="quantity", type="integer", example=20),
     * @OA\Property(property="created_at", type="string", example="2021-08-07T05:54:34.000000Z"),
     * @OA\Property(property="updated_at", type="string", example="2021-08-07T05:54:34.000000Z"),
     */
    protected $fillable = [
        'name',
        'category_id',
        'sku',
        'price',
        'quantity',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'price' => 'float',
        'quantity' => 'integer',
    ];

    protected $with = [
        'category'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

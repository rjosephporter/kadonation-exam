<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema()
 */
class Category extends Model
{
    use HasFactory;

    /**
     * @OA\Property(property="id", type="integer", example=4),
     * @OA\Property(property="name", type="string", example="Furnitures"),
     * @OA\Property(property="created_at", type="string", example="2021-08-07T05:54:34.000000Z"),
     * @OA\Property(property="updated_at", type="string", example="2021-08-07T05:54:34.000000Z"),
     */
    protected $fillable = [
        'name'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

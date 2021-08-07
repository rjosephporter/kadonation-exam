<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * @OA\RequestBody(
     *      request="ProductRequest",
     *      @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="name", type="string", example="Cyberpunk 2077"),
     *           @OA\Property(property="category_id", type="integer", example=1),
     *           @OA\Property(property="sku", type="string", example="A0005"),
     *           @OA\Property(property="price", type="number", example=59.99),
     *           @OA\Property(property="quantity", type="integer", example=20)
     *      )
     * )
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku' => [
                'required',
                'max:255',
                Rule::unique('products')->ignore($this->route('product')),
            ],
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required'],
            'discount_id' => ['nullable'],
            'name' => ['required', 'string', 'max:50', 'min:3'],
            'slug' => ['required', 'string', 'max:50', 'min:3', Rule::unique(Product::class)->ignore(request()->route('product')->id ?? '')],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required'],
            'stock' => ['required'],
            'image' => [Rule::requiredIf($this->method() === 'POST'), 'image', 'mimes:jpg,jpeg,png,svg,webp,gif', 'max:500'],
            'is_active' => ['required', 'string'],
        ];
    }
}

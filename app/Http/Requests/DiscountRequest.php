<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'disc_percent' => (int) $this->disc_percent,
        ]);
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
            'name' => ['required', 'string', 'max:50', 'min:3'],
            'disc_percent' => ['required'],
            'image' => [Rule::requiredIf($this->method() === 'POST'), 'image', 'mimes:jpg,jpeg,png,svg,webp,gif', 'max:2048'],
            'is_active' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.max' => 'Image Max Size 2MB',
        ];
    }
}

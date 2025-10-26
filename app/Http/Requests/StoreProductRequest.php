<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {    //to require authentication to create we need to set up breeze we will just leave it like this for now
        //return auth()->check();
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

            'name' => 'required|string|min:3',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:Electronics,Clothing,Books,Home & Garden,Sports & Outdoors,Beauty & Personal Care,Toys & Games,Automotive,Health & Household,Jewelry',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048|dimensions:max_width=2000,max_height=2000', // 2MB max
            'brand' => 'nullable|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'in_stock' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',



        ];
    }
    public function messages(): array
    {
        return  [
            'image.required' => 'The product image is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.max' => 'The image may not be greater than 2MB.',
            'name.min' => 'The product name must be at least 3 characters.',
            'description.min' => 'The description must be at least 10 characters.',
        ];
    }
}

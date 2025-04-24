<?php

namespace App\Http\Requests;

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
        $rules = [
            'primary_image' => 'required|image',
            'images.*' => 'nullable|image',
            'name' => 'required|string',
            'slug' => 'nullable|string',
            'category_id' => 'required|integer',
            'status' => 'required',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'is_featured' => 'required|integer',
            'description' => 'required',
        ];
        
        if($this->routeIs('products.update')){
            $rules['primary_image'] = 'nullable|image';
        }

        return $rules;

        
    }
}

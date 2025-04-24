<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                Rule::unique('categories')->ignore($this->category)->where(function ($query) {
                    return $query->where('parent_id', $this->parent_id);
                })                
            ],
            'nameMain' => 'nullable',
            'status' => 'required',
            'parent_id' => [
                'nullable',
                'exists:categories,id'
            ],
        ];
    }


    public function messages(): array
    {
        $parentCategoryName = $this->parent_id
            ? (Category::find($this->parent_id)?->name ?? 'نامشخص')
            : 'اصلی';

        return [
            'name.unique' => " دسته‌بندی " . $parentCategoryName . ' وجود دارد.',
        ];
    }
}
